<?php

namespace Controllers;

class BaseController
{
    protected function view(string $path, array $data = [])
    {
        extract($data);
        $file = PATH_ROOT . '/views/' . $path . '.php';

        if (!file_exists($file)) {
            echo "View not found: $file";
            return;
        }

        require $file;
    }

    /**
     * Simple redirect
     */
    protected function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }

    /**
     * Redirect with flash message
     */
    protected function redirectWithMessage($url, $message, $type = 'success')
    {
        $_SESSION[$type] = $message;
        header('Location: ' . $url);
        exit;
    }

    /**
     * Return JSON response
     */
    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Verify CSRF token for POST requests
     */
    protected function verifyCsrf()
    {
        $token = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($token)) {
            $this->redirectWithMessage(BASE_URL, 'Invalid CSRF token. Please try again.', 'error');
        }
    }

    /**
     * Validate input with optional rules
     */
    protected function validate($data, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? '';
            $rulesArray = explode('|', $fieldRules);

            foreach ($rulesArray as $rule) {
                if ($rule === 'required' && empty($value)) {
                    $errors[$field][] = ucfirst($field) . ' is required';
                }

                if (str_starts_with($rule, 'min:')) {
                    $min = (int)substr($rule, 4);
                    if (strlen($value) < $min) {
                        $errors[$field][] = ucfirst($field) . " must be at least {$min} characters";
                    }
                }

                if (str_starts_with($rule, 'max:')) {
                    $max = (int)substr($rule, 4);
                    if (strlen($value) > $max) {
                        $errors[$field][] = ucfirst($field) . " must not exceed {$max} characters";
                    }
                }

                if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = ucfirst($field) . ' must be a valid email';
                }

                if ($rule === 'numeric' && !is_numeric($value)) {
                    $errors[$field][] = ucfirst($field) . ' must be numeric';
                }
            }
        }

        return empty($errors) ? null : $errors;
    }

    /**
     * Generate slug from string (Vietnamese friendly)
     */
    protected function generateSlug($string)
    {
        $string = trim($string);
        $string = mb_strtolower($string, 'UTF-8');

        // Convert Vietnamese characters to ASCII
        $vietnameseMap = [
            'á' => 'a', 'à' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a',
            'ă' => 'a', 'ắ' => 'a', 'ằ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a',
            'â' => 'a', 'ấ' => 'a', 'ầ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a',
            'đ' => 'd',
            'é' => 'e', 'è' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e',
            'ê' => 'e', 'ế' => 'e', 'ề' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e',
            'í' => 'i', 'ì' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o',
            'ô' => 'o', 'ố' => 'o', 'ồ' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o',
            'ơ' => 'o', 'ớ' => 'o', 'ờ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o',
            'ú' => 'u', 'ù' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u',
            'ư' => 'u', 'ứ' => 'u', 'ừ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u',
            'ý' => 'y', 'ỳ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y',
        ];

        $string = strtr($string, $vietnameseMap);

        // Remove special characters
        $string = preg_replace('/[^a-z0-9\s-]/', '', $string);

        // Replace multiple spaces/hyphens with single hyphen
        $string = preg_replace('/[\s-]+/', '-', $string);

        // Remove leading/trailing hyphens
        $string = trim($string, '-');

        return $string;
    }

    /**
     * Upload image file
     */
    protected function uploadImage($file, $destination = 'uploads')
    {
        // Validate file
        if (!isset($file['error']) || is_array($file['error'])) {
            return ['success' => false, 'error' => 'Tệp không hợp lệ'];
        }

        // Check upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Lỗi khi tải lên tệp'];
        }

        // Check file size (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            return ['success' => false, 'error' => 'Kích thước tệp vượt quá 2MB'];
        }

        // Check file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            return ['success' => false, 'error' => 'Chỉ chấp nhận tệp JPG, PNG, GIF, WEBP'];
        }

        // Create destination directory if not exists
        $uploadDir = PATH_ROOT . '/' . $destination;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . '/' . $filename;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            return ['success' => false, 'error' => 'Không thể lưu tệp'];
        }

        return [
            'success' => true,
            'path' => $destination . '/' . $filename,
            'filename' => $filename
        ];
    }
}
