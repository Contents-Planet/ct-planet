<?

namespace app\service;

require_once  $_SERVER["DOCUMENT_ROOT"] . '/app/service/MysqlService.php';

use \app\service\MysqlService;
use Exception;

class CtplanetService extends MysqlService
{
    private $table = '';

    function __construct($table)
    {
        $this->table = $table;
    }

    public function referenceList($team ="")
    {
        try{
            $orderBy = [
                "column" => "seq",
                "sort" => "desc"
            ];
            
            $column = [
               "seq",
               "subject",
               "content",
               "client",
               "year",
               "thumb_img",
               "team",
               "etc1",
               "etc2",
               "etc3",
               "etc4",
               "type",
               "subject_color",
            ];

            $where = [
                "is_active = 'Y' "
            ];

            if($team != ''){
                $where[] = "team = '".$team."'";
            }
            
            return $this->getMultiSelect($this->table, $where, $column, $orderBy);
            
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }
    
    public function referenceCount($team): mixed
    {
        $where = [
            "is_active = 'Y' "
        ];

        if($team != ''){
            $where[] = "team = '".$team."'";
        }

        return $this->getDataCount($this->table, $where);
    }

    public function referenceDetail($seq): array
    {
        $where = ["seq = " . $seq];
        $column = [
            "seq",
            "subject",
            "content",
            "client",
            "year",
            "thumb_img",
            "team",
            "etc1",
            "etc2",
            "etc3",
            "etc4",
            "type",
            "subject_color",
        ];

        return $this->getSingleSelect($this->table, $where, $column);
    }

}
