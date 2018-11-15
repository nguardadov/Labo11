<?php
    require('../models/Task.php');
    require('../interfaces/metodos.php');
    require('../connecion/Connecion.php');
   // require('../models/Task.php');

    class TaskDao implements metodos
    {

        public function readAll()
        {
            //extraemos la instancia de nuestra base de datos
            $instance = Connecion::getInstance();
            //obtemos la connecion
            $conn = $instance->getCnx();
            
            $tasks= array(); //arreglo donde estaran todas las tareas
            $result = $conn->query('select * from tasks'); // ejecutamos la consulta para que nos devuelva todas las tareas
            while($row = $result->fetch_object()) //convertimos el el resultado de las filas a objectos
            {
                array_push($tasks,$row); //agregamos el objeto a nuestro arreglo
            }
            $conn->close(); //cerramos la connecion a la base de datos
            return json_encode($tasks); //devolvemos los datos
           
            
        }


        public function read($id)
        {
            $instance = Connecion::getInstance();
            $conn = $instance->getCnx();
            $result = $conn->query(sprintf("select * from tasks where id='%s'",$id));
            $task = null;
            while($row = $result->fetch_object())
            {
                $task = $row;
            }
            $conn->close();
            return $task;
        }


        public function create($task)
        {
            $instance = Connecion::getInstance();
            $conn = $instance->getCnx();
            $sql = sprintf("insert into tasks (task, date_task) values('%s','%s')",$task->getTask(),$task->getDateTask());
            if ($conn->query($sql))
            {
                $conn->close();
                return true;
            }
            $conn->close();
            return false;
        }

        public function update($task)
        {
            $instance = Connecion::getInstance();
            $conn = $instance->getCnx();
            $sql = sprintf("update tasks set task='%s', date_task='%s' where id='%s'",$task->getTask(),$task->getDateTask(),$task->getId());
            if ($conn->query($sql))
            {
                $conn->close();
                return true;
            }
            $conn->close();
            return false;
        }

        public function delete($id)
        {
            $instance = Connecion::getInstance();
            $conn = $instance->getCnx();
            $sql = sprintf("delete from tasks where id='%s'",$id);
            if($conn->query($sql))
            {
                $conn->close();
                return true;
            }
            else
            {
                $conn->close();
                return false;
            }
        }
    }
?>