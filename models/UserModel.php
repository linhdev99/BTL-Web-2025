<?php

namespace Models;

use Utils\Utils;

class UserModel extends BaseModel
{
  protected string $table = "users";   // tên bảng trong DB

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Lấy user theo ID
   */
  public function getById($id)
  {
    return $this->getOne("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
  }

  /**
   * Cập nhật user (wrapper method để dễ dùng)
   */
  public function updateUser($id, array $data)
  {
    return parent::update(
      $this->table,
      $data,
      "id = :id",
      ['id' => $id]
    );
  }

  /**
   * Tạo token mới và cập nhật vào DB
   */
  public function refreshRememberToken(string $username): string
  {
    $randomString = Utils::randomString(64);

    $this->update(
      $this->table,
      ['rememberToken' => $randomString],
      "username = :username",
      ['username' => $username]
    );

    return $randomString;
  }

  /**
   * Lấy tất cả user (view UserPreview)
   */
  public function getAllUser()
  {
    try {
      return $this->getAll("SELECT * FROM UserPreview");
    } catch (\Exception $e) {
      return [];
    }
  }

  /**
   * Lấy tổng user (trừ role = 1)
   */
  public function getTotalUser()
  {
    try {
      $row = $this->getOne(
        "SELECT COUNT(*) AS total FROM {$this->table} WHERE role_id != 1"
      );

      return $row ? $row['total'] : 0;
    } catch (\Exception $e) {
      return 0;
    }
  }
}
