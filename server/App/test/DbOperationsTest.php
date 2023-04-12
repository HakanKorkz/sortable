<?php

namespace Korkz\Server\App\test;

use Exception;
use Korkz\Server\App\Connect\DbOperations;
use PHPUnit\Framework\TestCase;

class DbOperationsTest extends TestCase {
    protected static DbOperations $dbOperations;

    public static function setUpBeforeClass(): void {
        self::$dbOperations = new DbOperations();
    }

    /**
     * @throws Exception
     */
    public function testInsertData() {
        $table = 'categories';
        $data = [
            'parent_id' => 0,
            'category_name' => 'Test54',
            'category_sort_by' => 54
        ];
        $result = self::$dbOperations->insertData($table, $data);
        $this->assertTrue($result);
    }

    /**
     * @throws Exception
     */
    public function testUpdateData() {
        $table = 'categories';
        $data = [
            'parent_id' => 0,
            'category_name' => 'Test',
            'category_sort_by' => 1
        ];
        $where = ['ID' => 1];
        $result = self::$dbOperations->updateData($table, $data, $where);
        $this->assertTrue($result);
    }

    /**
     * @throws Exception
     */
    public function testGetData() {
        $table = 'categories';
        $columns = ['category_name'];
        $where = [
            'ID' => 1
        ];
        $orderBy = 'category_name ASC';
        $limit = 1;
        $result = self::$dbOperations->getData($table, $columns, $where, $orderBy, $limit);
        $this->assertIsArray($result);
    }

    /**
     * @throws Exception
     */
    public function testDeleteData() {
        $table = 'categories';
        $where = [
            'ID' => 2
        ];
        $result = self::$dbOperations->deleteData($table,$where);
        $this->assertTrue($result,"Veri silindi");
    }
}
