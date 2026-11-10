<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\StudentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $result = null;
        $searchedTerm = '';
        $notFoundError = null;

        if ($request->filled('roll_no') || $request->filled('reg_no')) {
            $term = trim((string) $request->query('roll_no', ''));
            $regTerm = trim((string) $request->query('reg_no', ''));
            $searchedTerm = $term !== '' ? $term : $regTerm;

            $query = StudentResult::query();

            if ($term !== '') {
                $query->where(function ($q) use ($term) {
                    $q->where('roll_no', $term)
                      ->orWhere('reg_no', $term);
                });
            }

            if ($regTerm !== '') {
                $query->where('reg_no', $regTerm);
            }

            $result = $query->first();

            if (!$result) {
                $notFoundError = 'No academic record found! Please verify your Roll Number or Registration Number and try again.';
            }
        }

        return view('results.index', compact('result', 'searchedTerm', 'notFoundError'));
    }

    public function search(Request $request)
    {
        $term = trim((string) $request->input('roll_no', ''));
        $regTerm = trim((string) $request->input('reg_no', ''));

        if ($term === '' && $regTerm === '') {
            return redirect()->route('results.index')
                ->with('error', 'Please enter a valid Student Roll Number or Registration Number.');
        }

        $params = array_filter([
            'roll_no' => $term,
            'reg_no' => $regTerm,
        ], fn ($value) => $value !== '');

        return redirect()->route('results.index', $params);
    }

    public function verify($roll_no)
    {
        $result = StudentResult::where('roll_no', $roll_no)
            ->orWhere('reg_no', $roll_no)
            ->first();

        return redirect()->route('results.index', [
            'roll_no' => $result ? $result->roll_no : $roll_no,
        ]);
    }

    public function print(Request $request, $roll_no)
    {
        $result = StudentResult::where('roll_no', $roll_no)->firstOrFail();
        $isDownload = $request->boolean('download');

        $verifyUrl = route('results.index', ['roll_no' => $result->roll_no]);
        $rawQr = $result->qr_url ?: ('https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=' . urlencode($verifyUrl));
        $rawLogo = SiteSetting::get('headerLogoImage', '');

        $inlinedPhoto = $this->toInlineDataUri($result->photo, $isDownload) ?: $result->photo;
        $inlinedQr = $this->toInlineDataUri($rawQr, $isDownload) ?: $rawQr;
        $inlinedLogo = $this->toInlineDataUri($rawLogo, $isDownload) ?: $rawLogo;

        return view('results.print', compact('result', 'isDownload', 'inlinedPhoto', 'inlinedQr', 'inlinedLogo'));
    }

    /**
     * Convert local (or remote on PDF download) image URLs to inline data URIs for CORS-safe canvas/PDF export.
     */
    private function toInlineDataUri(?string $src, bool $fetchRemote = false): ?string
    {
        $src = trim((string) $src);
        if ($src === '') {
            return null;
        }
        if (str_starts_with($src, 'data:image/')) {
            return $src;
        }

        if (str_starts_with($src, '/')) {
            $localPath = public_path(ltrim($src, '/'));
            if (is_file($localPath)) {
                $mime = @mime_content_type($localPath) ?: 'image/png';
                $raw = @file_get_contents($localPath);
                if ($raw !== false) {
                    return 'data:' . $mime . ';base64,' . base64_encode($raw);
                }
            }
            return null;
        }

        if ($fetchRemote && (str_starts_with($src, 'http://') || str_starts_with($src, 'https://'))) {
            try {
                $response = Http::timeout(4)->get($src);
                if ($response->successful()) {
                    $mime = $response->header('Content-Type') ?: 'image/png';
                    if (str_contains($mime, ';')) {
                        $mime = trim(explode(';', $mime)[0]);
                    }
                    return 'data:' . $mime . ';base64,' . base64_encode($response->body());
                }
            } catch (\Throwable $e) {
                // Fall back to original URL if offline or remote host times out
            }
        }

        return null;
    }
}
