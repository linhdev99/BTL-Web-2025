-- Add banner settings for homepage carousel
-- Each banner has: image, title, description, button text, button link

-- Insert banner settings and site name (columns setting_type and description should already exist)
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_type`, `setting_group`, `description`) VALUES
-- Site Name & Logo
('site_name', 'BK Figure Lab', 'text', 'general', 'Tên cửa hàng'),
('site_logo', '', 'image', 'general', 'Logo cửa hàng'),
('site_tagline', 'Nơi hội tụ đam mê', 'text', 'general', 'Slogan ngắn'),
('site_description', 'Nơi hội tụ đam mê mô hình – nơi cảm hứng trở thành hiện thực. Chuyên cung cấp mô hình figure, xe hơi, anime chất lượng cao.', 'textarea', 'general', 'Mô tả ngắn về cửa hàng (hiển thị ở footer)'),

-- Footer Info
('footer_copyright', 'BK Figure Lab. All rights reserved.', 'text', 'general', 'Text bản quyền footer'),
('footer_tagline', 'Made with passion for collectors.', 'text', 'general', 'Tagline footer'),
('business_hours', 'Thứ 2 – CN: 8:00 – 21:00', 'text', 'general', 'Giờ làm việc'),

-- Contact Information (for both header top bar and footer)
('contact_address', '268 Lý Thường Kiệt, Phường 14, Quận 10, TP.HCM', 'textarea', 'contact', 'Địa chỉ cửa hàng'),
('contact_phone', '0853672403', 'text', 'contact', 'Số điện thoại'),
('contact_hotline', '0853672403', 'text', 'contact', 'Hotline hỗ trợ'),
('contact_email', 'contact@toyshopa.vn', 'email', 'contact', 'Email liên hệ'),

-- Social Media Links
('social_facebook', 'https://facebook.com/bkfigurelab', 'url', 'social', 'Link Facebook'),
('social_instagram', 'https://instagram.com/bkfigurelab', 'url', 'social', 'Link Instagram'),
('social_twitter', '', 'url', 'social', 'Link TikTok'),
('social_youtube', '', 'url', 'social', 'Link Youtube'),
-- Banner 1
('banner_1_image', '', 'image', 'banner', 'Ảnh banner 1 (1920x700px)'),
('banner_1_title', 'Chào mừng đến với Toy Model Shop', 'text', 'banner', 'Tiêu đề banner 1'),
('banner_1_description', 'Khám phá thế giới mô hình đồ chơi độc đáo và tinh xảo', 'textarea', 'banner', 'Mô tả banner 1'),
('banner_1_button_text', 'Khám phá ngay', 'text', 'banner', 'Text nút bấm banner 1'),
('banner_1_button_link', '/products', 'text', 'banner', 'Đường dẫn nút bấm banner 1'),

-- Banner 2
('banner_2_image', '', 'image', 'banner', 'Ảnh banner 2 (1920x700px)'),
('banner_2_title', 'Mô hình đa dạng chủ đề', 'text', 'banner', 'Tiêu đề banner 2'),
('banner_2_description', 'Từ anime, xe hơi, đến nhân vật điện ảnh', 'textarea', 'banner', 'Mô tả banner 2'),
('banner_2_button_text', '', 'text', 'banner', 'Text nút bấm banner 2 (để trống nếu không cần)'),
('banner_2_button_link', '', 'text', 'banner', 'Đường dẫn nút bấm banner 2'),

-- Banner 3
('banner_3_image', '', 'image', 'banner', 'Ảnh banner 3 (1920x700px)'),
('banner_3_title', 'Ưu đãi cực hot mỗi tuần', 'text', 'banner', 'Tiêu đề banner 3'),
('banner_3_description', 'Giảm giá lên đến 40% cho các sản phẩm nổi bật', 'textarea', 'banner', 'Mô tả banner 3'),
('banner_3_button_text', '', 'text', 'banner', 'Text nút bấm banner 3 (để trống nếu không cần)'),
('banner_3_button_link', '', 'text', 'banner', 'Đường dẫn nút bấm banner 3')

ON DUPLICATE KEY UPDATE
    `setting_value` = VALUES(`setting_value`),
    `description` = VALUES(`description`);
