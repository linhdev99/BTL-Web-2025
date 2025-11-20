<?php

namespace Models;

use Utils\Utils;

class UserModel extends BaseModel
{
  public function __construct()
  {
    parent::__construct();
    $this->name = 'user';
  }

  public function refreshRememberToken(string $username): string
  {
    $randomString = Utils::randomString(64);
    $this->update(['rememberToken' => $randomString], ["username" => $username]);
    return $randomString;
  }

  public function getAllUser()
  {
    try {
      $sql = "SELECT * FROM UserPreview";
      $result = $this->db->query($sql);
      $data = $result->fetch_all(mode: MYSQLI_ASSOC);
      return $data;
    } catch (\Exception $e) {
      return [];
    }
  }

  public function getTotalUser()
  {
    try {
      $sql = "SELECT COUNT(*) AS total FROM User WHERE role != 1";
      $result = $this->db->query($sql);
      $data = $result->fetch_all(mode: MYSQLI_ASSOC);
      return $data[0]['total'];
    } catch (\Exception $e) {
      return 0;
    }
  }
}
