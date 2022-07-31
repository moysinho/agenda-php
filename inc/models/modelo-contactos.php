<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if ($_POST['accion'] == 'crear') {
        // creara un nuevo registro en la base de datos
        require_once('../functions/bd.php');
        
        // Validar las entradas
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
        $empresa = filter_var($_POST['empresa'], FILTER_SANITIZE_STRING);
        $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
        
        try {
            $stmt = $conn->prepare("INSERT INTO contactos(nombre_contacto, empresa_contacto, telefono_contacto) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $empresa, $telefono);
            $stmt->execute();
            if ($stmt->affected_rows == 1) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'datos' => array(
                        'nombre' => $nombre,
                        'empresa' => $empresa,
                        'telefono' => $telefono,
                        'id_insertado' => $stmt->insert_id
                        )
                    );
                }
                $stmt->close();
                $conn->close();
            } catch (\Throwable $th) {
                $respuesta = array(
                    'error' => $th->getMessage()
                );
            }
            
            echo json_encode($respuesta);
        }
    }
    
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        if ($_GET['accion'] == 'borrar') {
            
            // borrar un registro en la base de datos
            require_once('../functions/bd.php');
            
            // Validar las entradas
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            
            try {
                $stmt = $conn->prepare("DELETE FROM contactos WHERE id_contacto = ? ");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                if ($stmt->affected_rows == 1) {
                    $respuesta = array(
                        'respuesta' => 'correcto'
                    );
                }
                $stmt->close();
                $conn->close();
            } catch (\Throwable $th) {
                $respuesta = array(
                    'error' => $th->getMessage()
                ); 
            }
            echo json_encode($respuesta);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['accion'] == 'editar') {

            // borrar un registro en la base de datos
            require_once('../functions/bd.php');

            // Validar las entradas
            $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
            $empresa = filter_var($_POST['empresa'], FILTER_SANITIZE_STRING);
            $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
            $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

            try {
                $stmt = $conn->prepare("UPDATE contactos SET nombre_contacto = ?, empresa_contacto = ?, telefono_contacto = ? WHERE id_contacto = ?");
                $stmt->bind_param("sssi", $nombre, $empresa, $telefono, $id);
                $stmt->execute();
                if ($stmt->affected_rows == 1) {
                    $respuesta = array(
                        'respuesta' => 'correcto'
                    );
                }
                $stmt->close();
                $conn->close();
            } catch (\Throwable $th) {
                $respuesta = array(
                    'error' => $th->getMessage()
                ); 
            }
            echo json_encode($respuesta);

        }
    }