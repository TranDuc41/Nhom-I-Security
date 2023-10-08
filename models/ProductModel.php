<?php

require_once 'BaseModel.php';

class ProductModel extends BaseModel {

    public function findProductById($id) {
        $sql = 'SELECT * FROM products WHERE id = '.$id;
        $product = $this->select($sql);

        return $product;
    }

    /**
     * Authentication user
     * @param $userName
     * @param $password
     * @return array
     */
    public function auth($userName, $password) {
        $md5Password = md5($password);
        $sql = 'SELECT * FROM users WHERE name = "' . $userName . '" AND password = "'.$md5Password.'"';

        $user = $this->select($sql);
        return $user;
    }

    /**
     * Delete user by id
     * @param $id
     * @return mixed
     */
    public function deleteProductById($id) {
        $sql = 'DELETE FROM products WHERE id = '.$id;
        return $this->delete($sql);

    }

    /**
     * Update user
     * @param $input
     * @return mixed
     */
    public function updateProduct($input) {

        // // Lấy thời gian cập nhật gần nhất của sản phẩm
        // $currentUpdatedAt = $this->getCurrentProductUpdatedAt($input['id']);
        // // Kiểm tra thời gian cập nhật trong dữ liệu đầu vào
        // if ($input['updated_at'] != $currentUpdatedAt) {
        //     // Nếu thời gian cập nhật không khớp, thông báo lỗi.
        //     echo '<script type="text/javascript">alert("Đã có dữ liệu mới hơi. Vui lòng tải lại trang để chỉnh sửa!");</script>';
        //     return false;
        // }

        $sql = 'UPDATE Products SET 
                 name = "' . $input['name'] .'", 
                 quantity="'. $input['quantity'] .'", price="'. $input['price'] .'", price_sale="'. $input['price_sale'] .'", updated_at = NOW()
                WHERE id = ' . $input['id'];

        $product = $this->update($sql);

        return $product;
    }

    public function getCurrentProductUpdatedAt($productId) {
        // Thực hiện truy vấn SQL để lấy giá trị updated_at từ cơ sở dữ liệu
        $sql = "SELECT updated_at FROM Products WHERE id = $productId";
        $result = $this->query($sql);
    
        // Kiểm tra nếu có kết quả trả về từ cơ sở dữ liệu
        if ($result) {
            // Lấy giá trị updated_at từ kết quả truy vấn
            $row = $result->fetch_assoc();
            return $row['updated_at'];
        }
    
        // Trả về null nếu không tìm thấy dữ liệu hoặc xảy ra lỗi truy vấn
        return null;
    }

    /**
     * Insert user
     * @param $input
     * @return mixed
     */

    /**
     * Search users
     * @param array $params
     * @return array
     */
    public function getProducts($params = []) {
        //Keyword
        if (!empty($params['keyword'])) {
            $sql = 'SELECT * FROM product WHERE name LIKE "%' . $params['keyword'] .'%"';

            //Keep this line to use Sql Injection
            //Don't change
            //Example keyword: abcef%";TRUNCATE banks;##
            $products = self::$_connection->multi_query($sql);

            //Get data
            $products = $this->query($sql);
        } else {
            $sql = 'SELECT * FROM products';
            $products = $this->select($sql);
        }

        return $products;
    }
}