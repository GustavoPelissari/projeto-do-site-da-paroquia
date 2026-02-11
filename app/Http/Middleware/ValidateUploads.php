<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

/**
 * Validate and secure file uploads.
 * Prevents path traversal, MIME type abuse, and double extensions.
 */
class ValidateUploads
{
    protected array $allowedMimes = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    protected array $deniedExtensions = [
        'php', 'php3', 'php4', 'php5', 'php7', 'phtml', 'phar', 'phps',
        'exe', 'com', 'bat', 'cmd', 'scr', 'vbs', 'js', 'jar',
        'zip', 'rar', '7z', 'tar', 'gz',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Validate files in request
        foreach ($request->files as $files) {
            if (is_array($files)) {
                foreach ($files as $file) {
                    $this->validateFile($file);
                }
            } elseif ($files) {
                $this->validateFile($files);
            }
        }

        return $next($request);
    }

    protected function validateFile($file): void
    {
        if (!$file || !$file->isValid()) {
            return;
        }

        // Check MIME type (real MIME, not just extension)
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $this->allowedMimes, true)) {
            abort(422, "Tipo de arquivo não permitido: {$mimeType}");
        }

        // Check for double extensions (e.g., file.php.jpg)
        $filename = $file->getClientOriginalName();
        $parts = explode('.', $filename);
        if (count($parts) > 2) {
            foreach (array_slice($parts, 1, -1) as $ext) {
                if (in_array(strtolower($ext), $this->deniedExtensions, true)) {
                    abort(422, "Extensão dupla não permitida: {$filename}");
                }
            }
        }

        // Check file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (in_array($extension, $this->deniedExtensions, true)) {
            abort(422, "Extensão não permitida: .{$extension}");
        }

        // Check for path traversal attempts
        if (strpos($filename, '..') !== false || strpos($filename, '/') !== false) {
            abort(422, "Nome de arquivo inválido detectado");
        }
    }
}
