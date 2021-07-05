<?php
/**
 * Defri Indra M
 * 2021-04-14
 */

class Connection
{
    protected $connection;
    protected $db_name;

    public function __construct($params)
    {
        $this->db_name = $params['dbname'];
        $this->connection = mysqli_connect($params['host'], $params['username'], $params['password'], $this->db_name) or die("Koneksi gagal");
    }

    public function query($query)
    {
        $response = mysqli_query($this->connection, $query);
        return $response;
    }

    private function buildFields($fields, $with_key = true)
    {
        $fields_query = "";

        $field_len = count($fields) - 1;
        $index = 0;
        foreach ($fields as $field_name => $val) {
            $escaped_value = mysqli_escape_string($this->connection, $val);
            if ($with_key) {
                $fields_query .= "`$field_name` = '$escaped_value'";
            } else {
                $fields_query .= "'$escaped_value'";
            }
            if ($index < $field_len) {
                $fields_query .= ",";
            }
            $index++;
        }

        return $fields_query;
    }

    private function where($op, $params)
    {
        $query = "";

        if (is_array($params[1])) {
            $query .= "({$this->where($params[1][0], $params[1])})";
        } else {
            $query .= "`{$params[1]}`";
        }

        $query .= " {$op}";

        if (is_array($params[2])) {
            $query .= " ({$this->where($params[2][0], $params[2])})";
        } else {
            $params[2] = mysqli_escape_string($this->connection, $params[2]);
            $query .= " '{$params[2]}'";
        }

        return $query;
    }

    public function buildQuery($params, $table)
    {
        $base_params = [
            "select" => ["*"],
        ];

        $base_params = array_merge($base_params, $params);

        if (isset($base_params['select'])):
            $select = "";
            $select_len = count($base_params['select']) - 1; //real index
            foreach ($base_params['select'] as $index => $val):
                $select .= "{$val}";
                if ($index < $select_len):
                    $select .= ",";
                endif;
            endforeach;
        endif;

        $query = "select {$select} from {$table}";

        if (isset($base_params['join'])):
            $join = "";
            if (isset($base_params['join'][0])):
                $join_len = count($base_params['join']) - 1;
                foreach ($base_params['join'] as $index => $joins):
                    $join .= " join {$joins['table']} on {$joins['on']}";
                    // if($index < $join_len):
                    //     $join .= ",";
                    // endif;
                endforeach;
            else:
                $join .= " join {$base_params['table']} on {$base_params['on']}";
            endif;

            $query .= $join;
        endif;

        if (isset($base_params['where'])):
            $query .= " where {$this->where($base_params['where'][0], $base_params['where'])}";
        endif;

        if (isset($base_params['group'])):
            $query .= " group by {$base_params['group']}";
        endif;

        if (isset($base_params['order'])):
            $query .= " order by {$base_params['order']}";
        endif;

        if (isset($base_params['limit'])):
            $query .= " limit {$base_params['limit']}";
        endif;

        return $query;
    }

    private function parseAsObj($mysqli_result)
    {
        $template = [];
        while ($res = mysqli_fetch_object($mysqli_result)) {
            $template[] = $res;
        }

        return $template;
    }

    private function parseAsArray($mysqli_result)
    {
        $template = [];
        while ($res = mysqli_fetch_array($mysqli_result)) {
            $template[] = $res;
        }

        return $template;
    }

    public function find($params, $table)
    {
        $query = $this->buildQuery($params, $table);

        return $this->parseAsObj($this->query($query));
    }

    public function findOne($params, $table)
    {
        $base_params = [
            "limit" => "1",
        ];
        $base_params = array_merge($base_params, $params);
        $query = $this->buildQuery($base_params, $table);
        $mysqli_result = $this->query($query);
        $template = (object) [];

        while ($res = mysqli_fetch_object($mysqli_result)) {
            $template = $res;
        }

        return $template == (object) [] ? null : $template;
    }

    public function update($fields, $table, $where = "1=1")
    {
        $query = "update {$table} set {$this->buildFields($fields)} where $where";
        return $this->query($query);
    }

    public function delete($table, $where = [])
    {
        $query = "delete from {$table}";
        $query .= " where {$this->where($where[0],$where)}";
        return $this->query($query);
    }

    public function insertOne($fields, $table)
    {
        if ($fields == []) {
            return false;
        }

        $field_list = [];
        foreach ($fields as $key => $val) {
            $field_list[] = $key;
        }

        $field_list = implode(",", $field_list);
        $query = "insert into {$table}($field_list) values ({$this->buildFields($fields, false)})";

        return $this->query($query);
    }

    public function getError()
    {
        return $this->connection->error;
    }

    public function getColumns($table_name, $config = [])
    {
        $unset = $config["unset"] ?? [];
        $without_key = $config["without_primary_key"] ?? true;

        $query = "select column_name from information_schema.columns where table_schema='{$this->db_name}' and table_name='$table_name'";
        $data = $this->parseAsArray($this->query($query));
        $columns = [];

        foreach ($data as $key) {
            $columns[] = $key['column_name'];
        }

        if ($without_key) {
            $primary_key = $this->getPrimaryKey($table_name);

            $unset[] = $primary_key;
        }

        foreach ($columns as $id => $col) {
            foreach ($unset as $key) {
                if ($key == $col) {
                    unset($columns[$id]);
                }
            }
        }

        return $columns;
    }

    public function getPrimaryKey($table_name)
    {
        $query = "select column_name from information_schema.columns where table_schema='{$this->db_name}' and table_name='$table_name' and column_key='PRI' limit 1";

        $data = mysqli_fetch_array($this->query($query));
        if (isset($data['column_name'])) {
            return $data['column_name'];
        }

        return null;
    }

    public function beginTransaction()
    {
        mysqli_begin_transaction($this->connection);
    }

    public function commit()
    {
        mysqli_commit($this->connection);
    }

    public function rollBack()
    {
        mysqli_rollback($this->connection);
    }
}
