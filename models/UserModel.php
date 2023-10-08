<?php

require_once 'BaseModel.php';

class UserModel extends BaseModel {

    public function findUserById($id) {
        $sql = 'SELECT * FROM users WHERE id = '.$id;
        $user = $this->select($sql);

        return $user;
    }

    public function findUser($keyword) {
        $sql = 'SELECT * FROM users WHERE fullname LIKE %'.$keyword.'%'. ' OR email LIKE %'.$keyword.'%';
        $user = $this->select($sql);

        return $user;
    }

    /**
     * Authentication user
     * @param $userName
     * @param $password
     * @return array
     */
    public function auth($userName, $password) {
        // $md5Password = md5($password);
        $sql = 'SELECT * FROM users WHERE name = "' . $userName . '" AND password = "'.$password.'"';

        $user = $this->select($sql);
        return $user;
    }

    /**
     * Delete user by id
     * @param $id
     * @return mixed
     */
    public function deleteUserById($id) {
        $sql = 'DELETE FROM users WHERE id = '.$id;
        return $this->delete($sql);

    }

    /**
     * Update user
     * @param $input
     * @return mixed
     */
    public function updateUser($input) {
        $sql = 'UPDATE users SET 
                 name = "' . mysqli_real_escape_string(self::$_connection, $input['name']) .'", 
                 password="'. md5($input['password']) .'"
                WHERE id = ' . $input['id'];

        $user = $this->update($sql);

        return $user;
    }

    // public function updateUser($input) {
    //     // Escape các giá trị trước khi chèn vào truy vấn SQL
    //     $name = htmlspecialchars(mysqli_real_escape_string(self::$_connection, $input['name']), ENT_QUOTES, 'UTF-8');
    //     $password = htmlspecialchars(mysqli_real_escape_string(self::$_connection, md5($input['password'])), ENT_QUOTES, 'UTF-8');
    //     $id = intval($input['id']); // Chuyển đổi id thành số nguyên
    
    //     // Tạo truy vấn SQL với các giá trị đã được escape
    //     $sql = "UPDATE users SET name='$name', password='$password' WHERE id=$id";
    
    //     // Thực hiện truy vấn
    //     $user = $this->update($sql);
    
    //     return $user;
    // }

    /**
     * Insert user
     * @param $input
     * @return mixed
     */
    public function insertUser($input) {
        $sql = "INSERT INTO `app_web1`.`users` (`name`, `password`) VALUES (" .
                "'" . $input['name'] . "', '".md5($input['password'])."')";

        $user = $this->insert($sql);

        return $user;
    }

    // public function insertUser($input) {
    //     // Escape tên người dùng trước khi chèn vào truy vấn SQL
    //     $escapedName = htmlspecialchars($input['name'], ENT_QUOTES, 'UTF-8');
        
    //     // Chuyển đổi mật khẩu thành md5 hash (đây không phải là phương pháp tốt nhất, nhưng chỉ để minh họa việc sử dụng htmlspecialchars)
    //     $hashedPassword = md5($input['password']);
    
    //     // Tạo truy vấn SQL với tên người dùng và mật khẩu đã được escape
    //     $sql = "INSERT INTO `app_web1`.`users` (`name`, `password`) VALUES ('" . $escapedName . "', '" . $hashedPassword . "')";
    
    //     // Thực hiện truy vấn
    //     $user = $this->insert($sql);
    
    //     return $user;
    // }

    /**
     * Search users
     * @param array $params
     * @return array
     */
    public function getUsers($params = []) {
        //Keyword
        if (!empty($params['keyword'])) {
            $sql = 'SELECT * FROM users WHERE name LIKE "%' . $params['keyword'] .'%"';

            //Keep this line to use Sql Injection
            //Don't change
            //Example keyword: abcef%";TRUNCATE banks;##
            $users = self::$_connection->multi_query($sql);

            //Get data
            $users = $this->query($sql);
        } else {
            $sql = 'SELECT * FROM users';
            $users = $this->select($sql);
        }

        return $users;
    }
}