<?

namespace app\service;

use Exception;
use mysqli;

class MysqlService
{
    private $database = 'ctplanet';
    private $host = 'planworks2024.cvjejucpf1xq.ap-northeast-2.rds.amazonaws.com';
    private $userid = 'root';
    private $password = 'plan!db6200**';
    protected $db;

    public function __construct($db = "ctplanet")
    {
        $this->database = $db;
        $this->db = $this->connectDB();
    }

    function __destruct()
    {
        mysqli_close($this->connectDB());
    }

    private function connectDB()
    {
        try {
            $dbconn = mysqli_connect($this->host, $this->userid, $this->password, $this->database);
            mysqli_set_charset($dbconn, "utf8");
            if (mysqli_connect_errno()) {
                echo (mysqli_connect_error());
                exit();
            } else {
                return $dbconn;
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    function getUidData($table, $uid): mixed
    {
        return $this->getDbData($table, 'uid=' . (int)$uid, '*');
    }

    // DB Query Cutom 함수
    /** 
     * param $table string
     * param $where string
     * param $column array
     */
    function getDbData($table, $where, $column): array
    {
        $result = mysqli_query($this->db, 'select ' . $this->getColumnFilter($column) . ' from ' . $table . $this->getSqlFilter($where));
        $row = mysqli_fetch_array($result);
        return $row;
    }

    function createRow($table, $data)
    {
        $keyArray = [];
        $valueArray = [];

        foreach ($data as $key => $val) {
            $keyArray[] = $key;
            $valueArray[] = "'" . $val . "'";
        }


        $query = "  INSERT INTO " . $table . " 
                    (" . $this->getColumnFilter($keyArray) . ") 
                    VALUES 
                    (" . $this->getColumnFilter($valueArray) . ")";

        mysqli_query($this->db, $query);
    }

    function getSingleSelect($table, $where, $column)
    {
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $mysqli = new mysqli($this->host, $this->userid, $this->password,$this->database);

            $query = 'SELECT ' . $this->getColumnFilter($column) . ' FROM ' . $table
            . $this->getSqlFilter($where);

            $result = $mysqli->query($query);

            $cnt = 0;

            $results["result"] = 200;
            
            while ($row = $result->fetch_row()) {
                $results["datas"]["seq"] = $row[0];
                $results["datas"]["subject"] = $row[1];
                $results["datas"]["content"] = $row[2];
                $results["datas"]["client"] = $row[3];
                $results["datas"]["year"] = $row[4];
                $results["datas"]["thumb_img"] = $row[5];
                $results["datas"]["team"] = $row[6];
                $results["datas"]["etc1"] = $row[7];
                $results["datas"]["etc2"] = $row[8];
                $results["datas"]["etc3"] = $row[9];
                $results["datas"]["etc4"] = $row[11];
                $results["datas"]["type"] = $row[12];
                $results["datas"]["subject_color"] = $row[13];
            }

            $rowQuery = 'SELECT seq,bg_img,img,bg_color,overview FROM portfolio_row WHERE portfolio_seq = '. $results["datas"]["seq"];

            $rowResult = $mysqli->query($rowQuery);

            while ($row2 = $rowResult->fetch_row()) {
                $results["datas"]["section"][$cnt]["seq"] = $row2[0];
                $results["datas"]["section"][$cnt]["bg_img"] = $row2[1];
                $results["datas"]["section"][$cnt]["img"] = $row2[2];
                $results["datas"]["section"][$cnt]["bg_color"] = $row2[3];
                $results["datas"]["section"][$cnt]["overview"] = $row2[4];
                $cnt++;
            }

            return $results;
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    
    }

    function getMultiSelect($table, $where, $column, $orderBy, $page = 1, $listNum = 100)
    {
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $mysqli = new mysqli($this->host, $this->userid, $this->password,$this->database);

            $query = 'SELECT ' . $this->getColumnFilter($column) . ' FROM ctplanet.' . $table
            . $this->getSqlFilter($where)
            . $this->getOrderFilter($orderBy);

            $result = $mysqli->query($query);

            $countQuery = 'SELECT COUNT(1) FROM ctplanet.' . $table
            . $this->getSqlFilter($where)
            . $this->getOrderFilter($orderBy);

            $totalCount = mysqli_fetch_row($mysqli->query($countQuery));

            $cnt = 0;
            $results["result"] = 200;
            $results["totalCount"] = $totalCount[0];

            while ($row = $result->fetch_row()) {
              $results["datas"][$cnt]["seq"] = $row[0];
              $results["datas"][$cnt]["subject"] = $row[1];
              $results["datas"][$cnt]["content"] = $row[2];
              $results["datas"][$cnt]["client"] = $row[3];
              $results["datas"][$cnt]["year"] = $row[4];
              $results["datas"][$cnt]["thumb_img"] = $row[5];
              $results["datas"][$cnt]["team"] = $row[6];
              $results["datas"][$cnt]["etc1"] = $row[7];
              $results["datas"][$cnt]["etc2"] = $row[8];
              $results["datas"][$cnt]["etc3"] = $row[9];
              $results["datas"][$cnt]["etc4"] = $row[11];
              $results["datas"][$cnt]["type"] = $row[12];
              $results["datas"][$cnt]["subject_color"] = $row[13];
              $cnt++;
          }
            return $results;
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    // DB Query result 함수
    function getDbresult($table, $where, $column): mixed
    {
        $result = mysqli_query($this->db, 'select ' . $this->getColumnFilter($column) . ' from ' . $table . $this->getSqlFilter($where));
        return $result;
    }

    //DB데이터 ARRAY -> 테이블에 출력할 데이터 배열
    function getDbArray($table, $where, $column, $orderby, $rowsPage, $curPage): mixed
    {
        $sql = 'select ' . $this->getColumnFilter($column) . ' from ' . $table . $this->getSqlFilter($where) . ($orderby ? ' order by ' . $orderby : '') . ($rowsPage ? ' limit ' . (($curPage - 1) * $rowsPage) . ', ' . $rowsPage : '');
        if ($result = mysqli_query($this->db, $sql)) {
            return $result;
        }
    }

    //DB데이터 레코드 총 개수
    function getDataCount($table, $where): int
    {
        $sql = 'select count(*) from ' . $table . $this->getSqlFilter($where);
        if ($result = mysqli_query($this->db, $sql)) {
            $rows = mysqli_fetch_row($result);
            return $rows[0] ? $rows[0] : 0;
        }
    }

    //DB업데이트
    function getDbUpdate($table, $set, $where): void
    {
        mysqli_query($this->db, "update " . $table . " set " . $this->getColumnFilter($set) . $this->getSqlFilter($where));
    }

    //DB업데이트
    function updateRows($table, $set, $where): void
    {
        mysqli_query($this->db, "update " . $table . " set " . $this->getSetFilter($set) . $this->getSqlFilter($where));
    }

    //DB삭제
    function getDbDelete($table, $where): void
    {
        mysqli_query($this->db, "delete from " . $table . $this->getSqlFilter($where));
    }

    //Where필터링
    function getSqlFilter($sql): string
    {
        $returnSql = " where ";
        $returnSql .= implode(' AND ', $sql);
        return (!empty($sql)) ? $returnSql : "";
    }

    //column 필터링
    function getColumnFilter($column): string
    {
        $afterColumn = implode(',', $column);
        return $afterColumn;
    }

    //update SET 필터링
    function getSetFilter($set): string
    {
        $afterArray = [];
        foreach ($set as $key => $val) {
            $afterArray[] = $key . " = '" . $val . "'";
        }
        $afterSet = implode(',', $afterArray);
        return $afterSet;
    }

    function getLimitFilter($page, $listNum): string
    {
        $startNum = ($page - 1) * $listNum;
        $endNum = $listNum;
        $limit = " limit " . $startNum . ", " . $endNum;
        return (!empty($page) || !empty($page)) ? $limit : "";
    }

    function getOrderFilter($orderBy): string
    {
        return (!empty($orderBy['column']) || !empty($orderBy['sort'])) ? " order by " . $orderBy['column'] . " " . $orderBy['sort'] : "";
    }
}
