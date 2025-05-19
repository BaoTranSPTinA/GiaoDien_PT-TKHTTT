<?php
class Database
{
    private const CONFIG_SERVERNAME = "localhost";
    private const CONFIG_USERNAME = "root";
    private const CONFIG_PASSWORD = "";
    private const CONFIG_DBNAME = "giao_dien";

    public $conn;
    public $query = null;
    public $stmt = null;

    public function __construct()
    {
        $this->conn = new mysqli(
            self::CONFIG_SERVERNAME,
            self::CONFIG_USERNAME,
            self::CONFIG_PASSWORD,
            self::CONFIG_DBNAME
        );

        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }

        // Thiết lập mã hóa UTF-8
        $this->conn->set_charset("utf8mb4");
    }

    public function set_query($sql)
    {
        if (!$this->conn || $this->conn->connect_error) {
            throw new Exception("Kết nối cơ sở dữ liệu không hợp lệ hoặc đã đóng");
        }

        $this->query = $sql;
        $this->stmt = $this->conn->prepare($sql);
        if (!$this->stmt) {
            throw new Exception("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
        }
    }

    public function bind_params($types, ...$params)
    {
        if (!$this->stmt) {
            throw new Exception("Không có câu lệnh nào được chuẩn bị");
        }
        $this->stmt->bind_param($types, ...$params);
    }

    public function execute_query()
    {
        if (!$this->conn || $this->conn->connect_error) {
            throw new Exception("Không có kết nối cơ sở dữ liệu");
        }
        if (!$this->stmt) {
            throw new Exception("Không có câu lệnh nào được chuẩn bị");
        }
        $result = $this->stmt->execute();
        if (!$result) {
            throw new Exception("Thực thi câu lệnh thất bại: " . $this->stmt->error);
        }
        return $result;
    }

    public function fetch_row()
    {
        if (!$this->stmt) {
            throw new Exception("Không có câu lệnh nào được chuẩn bị");
        }
        $result = $this->stmt->get_result();
        return $result->fetch_assoc();
    }

    public function fetch_all_rows()
    {
        if (!$this->stmt) {
            throw new Exception("Không có câu lệnh nào được chuẩn bị");
        }
        $result = $this->stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function get_last_insert_id()
    {
        if (!$this->conn || $this->conn->connect_error) {
            throw new Exception("Không có kết nối cơ sở dữ liệu");
        }
        return $this->conn->insert_id;
    }

    public function get_last_error()
    {
        if ($this->stmt) {
            return $this->stmt->error;
        }
        return $this->conn->error;
    }

    public function begin_transaction()
    {
        if (!$this->conn || $this->conn->connect_error) {
            throw new Exception("Không có kết nối cơ sở dữ liệu");
        }
        $this->conn->begin_transaction();
    }

    public function commit_transaction()
    {
        if (!$this->conn || $this->conn->connect_error) {
            throw new Exception("Không có kết nối cơ sở dữ liệu");
        }
        $this->conn->commit();
    }

    public function rollback_transaction()
    {
        if (!$this->conn || $this->conn->connect_error) {
            throw new Exception("Không có kết nối cơ sở dữ liệu");
        }
        $this->conn->rollback();
    }

    public function __destruct()
    {
        if ($this->stmt) {
            $this->stmt->close();
        }
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>