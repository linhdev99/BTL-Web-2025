<?php

namespace Models;

use PDO;

class SettingsModel extends BaseModel
{
    private $cache = [];

    /**
     * Get all settings grouped by setting_group
     */
    public function getAllGrouped()
    {
        $sql = "SELECT * FROM site_settings ORDER BY setting_group, setting_key";
        $settings = $this->getAll($sql);

        $grouped = [];
        foreach ($settings as $setting) {
            $group = $setting['setting_group'];
            if (!isset($grouped[$group])) {
                $grouped[$group] = [];
            }
            $grouped[$group][] = $setting;
        }

        return $grouped;
    }

    /**
     * Get all settings as key-value array
     */
    public function getAllSettings()
    {
        if (!empty($this->cache)) {
            return $this->cache;
        }

        $sql = "SELECT setting_key, setting_value FROM site_settings";
        $settings = $this->getAll($sql);

        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }

        $this->cache = $result;
        return $result;
    }

    /**
     * Get a single setting value by key
     */
    public function getSetting($key, $default = '')
    {
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        $sql = "SELECT setting_value FROM site_settings WHERE setting_key = :key LIMIT 1";
        $result = $this->getOne($sql, ['key' => $key]);

        return $result ? $result['setting_value'] : $default;
    }

    /**
     * Update a setting value
     */
    public function updateSetting($key, $value)
    {
        $sql = "UPDATE site_settings SET setting_value = :value, updated_at = NOW()
                WHERE setting_key = :key";

        $result = $this->execute($sql, [
            'key' => $key,
            'value' => $value
        ]);

        // Clear cache
        $this->cache = [];

        return $result;
    }

    /**
     * Update multiple settings at once
     */
    public function updateMultiple($settings)
    {
        $this->db->beginTransaction();

        try {
            foreach ($settings as $key => $value) {
                $this->updateSetting($key, $value);
            }
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Create a new setting
     */
    public function createSetting($data)
    {
        $result = $this->insert('site_settings', $data);
        $this->cache = [];
        return $result;
    }

    /**
     * Delete a setting
     */
    public function deleteSetting($key)
    {
        $result = $this->delete('site_settings', 'setting_key = :key', ['key' => $key]);
        $this->cache = [];
        return $result;
    }

    /**
     * Get settings by group
     */
    public function getByGroup($group)
    {
        $sql = "SELECT * FROM site_settings WHERE setting_group = :group ORDER BY setting_key";
        return $this->getAll($sql, ['group' => $group]);
    }

    /**
     * Clear settings cache
     */
    public function clearCache()
    {
        $this->cache = [];
    }
}
