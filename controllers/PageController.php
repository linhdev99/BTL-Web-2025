<?php

namespace Controllers;

class PageController extends BaseController
{
    /**
     * About page
     */
    public function about()
    {
        $this->view('client/pages/about', [
            'pageTitle' => 'Giới thiệu'
        ]);
    }

    /**
     * Contact page - show form
     */
    public function contact()
    {
        $this->view('client/pages/contact', [
            'pageTitle' => 'Liên hệ'
        ]);
    }

    /**
     * Contact page - submit form
     */
    public function submitContact()
    {
        $name = sanitize($_POST['name'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $phone = sanitize($_POST['phone'] ?? '');
        $subject = sanitize($_POST['subject'] ?? '');
        $message = sanitize($_POST['message'] ?? '');
        $errors = [];

        // Validation
        if (empty($name)) {
            $errors[] = 'Vui lòng nhập họ tên';
        }

        if (empty($email)) {
            $errors[] = 'Vui lòng nhập email';
        } elseif (!validateEmail($email)) {
            $errors[] = 'Email không hợp lệ';
        }

        if (empty($subject)) {
            $errors[] = 'Vui lòng nhập tiêu đề';
        }

        if (empty($message)) {
            $errors[] = 'Vui lòng nhập nội dung';
        }

        if (empty($errors)) {
            // TODO: Save to database or send email
            // For now, just show success message
            $this->redirectWithMessage(BASE_URL . '/contact', 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất!', 'success');
        } else {
            $this->view('client/pages/contact', [
                'pageTitle' => 'Liên hệ',
                'errors' => $errors,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'subject' => $subject,
                'message' => $message
            ]);
        }
    }

    /**
     * FAQ page
     */
    public function faq()
    {
        $this->view('client/pages/faq', [
            'pageTitle' => 'Câu hỏi thường gặp'
        ]);
    }
}
