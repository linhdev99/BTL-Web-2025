<?php

/**
 * Settings Helper Functions
 * Provides global functions to access site settings easily
 */

use Models\SettingsModel;

// Global settings cache
$GLOBALS['site_settings_cache'] = null;

/**
 * Get all settings as key-value array
 */
function getAllSettings()
{
    if ($GLOBALS['site_settings_cache'] === null) {
        $settingsModel = new SettingsModel();
        $GLOBALS['site_settings_cache'] = $settingsModel->getAllSettings();
    }
    return $GLOBALS['site_settings_cache'];
}

/**
 * Get a single setting value by key
 */
function getSetting($key, $default = '')
{
    $settings = getAllSettings();
    return $settings[$key] ?? $default;
}

/**
 * Get site name
 */
function getSiteName()
{
    return getSetting('site_name', 'BK Figure Lab');
}

/**
 * Get site tagline
 */
function getSiteTagline()
{
    return getSetting('site_tagline', 'For True Figure Lovers');
}

/**
 * Get contact address
 */
function getContactAddress()
{
    return getSetting('contact_address', '268 Lý Thường Kiệt, Phường 14, Quận 10, TP.HCM');
}

/**
 * Get contact phone
 */
function getContactPhone()
{
    return getSetting('contact_phone', '0123 456 789');
}

/**
 * Get contact email
 */
function getContactEmail()
{
    return getSetting('contact_email', 'contact@bkfigurelab.vn');
}

/**
 * Get hotline
 */
function getContactHotline()
{
    return getSetting('contact_hotline', '1900 xxxx');
}

/**
 * Get working hours
 */
function getWorkingHours()
{
    return getSetting('contact_working_hours', 'Thứ 2 - Thứ 7: 9:00 - 21:00<br>Chủ nhật: 10:00 - 20:00');
}

/**
 * Get about page title
 */
function getAboutTitle()
{
    return getSetting('about_title', 'Về chúng tôi');
}

/**
 * Get about page content (HTML)
 */
function getAboutContent()
{
    return getSetting('about_content', '<p>Chào mừng bạn đến với BK Figure Lab!</p>');
}

/**
 * Get footer copyright text
 * Automatically replaces {year} with current year
 */
function getFooterCopyright()
{
    $text = getSetting('footer_copyright', '© {year} BK Figure Lab. All rights reserved.');
    return str_replace('{year}', date('Y'), $text);
}

/**
 * Get social media links
 */
function getSocialLinks()
{
    return [
        'facebook' => getSetting('social_facebook', ''),
        'instagram' => getSetting('social_instagram', ''),
        'youtube' => getSetting('social_youtube', ''),
        'tiktok' => getSetting('social_tiktok', '')
    ];
}

/**
 * Clear settings cache (useful after updating settings)
 */
function clearSettingsCache()
{
    $GLOBALS['site_settings_cache'] = null;
}
