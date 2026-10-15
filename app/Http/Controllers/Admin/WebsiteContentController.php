<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteContentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class WebsiteContentController extends Controller
{
    private const PAGES = [
        'home' => 'Home Page',
        'about' => 'About Page',
        'doctors' => 'Doctors Page',
        'departments' => 'Departments Page',
        'services' => 'Services Page',
        'contact' => 'Contact Page',
        'appointment' => 'Appointment Page',
    ];

    public function index(Request $request)
    {
        $page = $request->query('page', 'home');

        if (!is_string($page) ||
            !array_key_exists($page, self::PAGES)) {
            abort(404);
        }

        $items = WebsiteContentItem::query()
            ->where('page', $page)
            ->orderBy('id')
            ->get();

        return view('admin.website-content.index', [
            'page' => $page,
            'pages' => self::PAGES,
            'items' => $items,
        ]);
    }

    public function update(Request $request)
    {
        // STEP 1: Basic request validation
        $validated = $request->validate([
            'page' => [
                'required',
                'string',
                Rule::in(array_keys(self::PAGES)),
            ],
            'content' => [
                'required',
                'array',
            ],
            'content.*' => [
                'nullable',
                'string',
                'max:10000',
            ],
        ]);

        $page = $validated['page'];
        $submitted = $validated['content'];

        // STEP 2: Fetch registered CMS fields
        $items = WebsiteContentItem::query()
            ->where('page', $page)
            ->get()
            ->keyBy('content_key');

        // STEP 3: Reject unknown content keys
        $unknownKeys = array_diff(
            array_keys($submitted),
            $items->keys()->all()
        );

        if (!empty($unknownKeys)) {
            return back()
                ->withErrors([
                    'content' => 'Invalid CMS fields submitted.',
                ])
                ->withInput();
        }

        // STEP 4: Build validation rules per field
      
$counterKeys = [
    // HOME HERO COUNTERS
    'home_hero_doctors_count',
    'home_hero_departments_count',
    'home_hero_patients_count',

    // HOME STATS COUNTERS
    'home_stats_experience_count',
    'home_stats_doctors_count',
    'home_stats_patients_count',
    'home_stats_support_count',
];


        $fieldRules = [];

        foreach ($items as $key => $item) {
            if (!array_key_exists($key, $submitted)) {
                continue;
            }

            if ($item->type === 'image') {
                continue;
            }

            if (in_array($key, $counterKeys, true)) {
                $fieldRules["content.$key"] = [
                    'required',
                    'regex:/^\d{1,8}$/',
                ];
            } elseif ($item->type === 'url') {
                $fieldRules["content.$key"] = [
                    'nullable',
                    'string',
                    'max:2048',
                    function ($attribute, $value, $fail) {
                        if ($value === null || $value === '') {
                            return;
                        }

                        $scheme = parse_url(
                            $value,
                            PHP_URL_SCHEME
                        );

                        $external = filter_var(
                            $value,
                            FILTER_VALIDATE_URL
                        ) && in_array(
                            strtolower((string) $scheme),
                            ['http', 'https'],
                            true
                        );

                        $internal = str_starts_with($value, '/')
                            && !str_starts_with($value, '//')
                            && !str_contains($value, '\\');

                        if (!$external && !$internal) {
                            $fail(
                                'Enter a valid HTTP/HTTPS URL or an internal path.'
                            );
                        }
                    },
                ];
            } else {
                $fieldRules["content.$key"] = [
                    'nullable',
                    'string',
                    'max:10000',
                ];
            }
        }

        // STEP 5: Validate ALL fields before saving
        Validator::make(
            ['content' => $submitted],
            $fieldRules
        )->validate();

        // STEP 6: Save all changes safely
        DB::transaction(function () use ($items, $submitted) {
            foreach ($items as $key => $item) {
                if (!array_key_exists($key, $submitted)) {
                    continue;
                }

                // Images will be managed by Media Library
                if ($item->type === 'image') {
                    continue;
                }

                $item->value = $submitted[$key];
                $item->save();
            }
        });

        return redirect()
            ->route('admin.website-content.index', [
                'page' => $page,
            ])
            ->with(
                'success',
                'Website content updated successfully.'
            );
    }
}
