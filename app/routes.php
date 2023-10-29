<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    // get menu
    $app->get('/menu', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL get_menu()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    //get menu transaksi
    $app->get('/menu_transaksi', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL get_menu_transaksi()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    //get pembeli
    $app->get('/pembeli', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL get_pembeli()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    //get kasir
    $app->get('/kasir', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL get_kasir()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    //get transaksi
    $app->get('/transaksi', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL get_transaksi()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });


    // get menu by id
    $app->get('/menu/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL get_menuById(?)');
        $query->execute([$args['id']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    //get menu transaksi by id
    $app->get('/menu_transaksi/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL get_menu_transaksiById(?)');
        $query->execute([$args['id']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    //get pembeli by id
    $app->get('/pembeli/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL get_pembeliById(?)');
        $query->execute([$args['id']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    //get kasir by id
     $app->get('/kasir/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL get_kasirById(?)');
        $query->execute([$args['id']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    //get transaksi by id
     $app->get('/transaksi/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL get_transaksiById(?)');
        $query->execute([$args['id']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

   // post data menu
    $app->post('/menu', function (Request $request, Response $response) {  
        $db = $this->get(PDO::class);

        $data = $request->getParsedBody();
        $id_menu = $data['id_menu'];
        $Nama_Menu = $data['Nama_Menu'];
        $harga = $data['harga'];
        
        $query = $db->prepare('SET @P3=""; CALL tambah_menu(:id_menu_param, :Nama_Menu_param, :harga_param, @P3)');
        $query->bindParam(':id_menu_param', $id_menu, PDO::PARAM_INT);
        $query->bindParam(':Nama_Menu_param', $Nama_Menu, PDO::PARAM_STR);
        $query->bindParam(':harga_param', $harga, PDO::PARAM_STR);

        $query->execute();
        $response->getBody()->write(json_encode([
            'message' => 'Berhasil menambahkan menu'
        ]));

        return $response->withHeader("Content-Type", "application/json");
    });

    //post data menu transaksi
     $app->post("/menu_transaksi", function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $data = $request->getParsedBody();
        $id_menu_transaksi = $data['id_menu_transaksi'];
        $id_menu = $data['id_menu'];
        $jumlah_menu_transaksi = $data['jumlah_menu_transaksi'];

        $query = $db->prepare('SET @P3=""; CALL tambah_menu_transaksi(:id_menu_transaksi_param, :id_menu_param, :jumlah_menu_transaksi_param, @P3)');
        $query->bindParam(':id_menu_transaksi_param', $id_menu_transaksi, PDO::PARAM_INT);
        $query->bindParam(':id_menu_param', $id_menu, PDO::PARAM_INT);
        $query->bindParam(':jumlah_menu_transaksi_param', $jumlah_menu_transaksi, PDO::PARAM_STR);

        $query->execute();
        $response->getBody()->write(json_encode([
            'message'=> 'Berhasil menambahkan menu transaksi'
        ]));
        return $response->withHeader("Content-Type", "application/json");
    });


    //post data pembeli
     $app->post("/pembeli", function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $data = $request->getParsedBody();
        $id_pembeli = $data['id_pembeli'];
        $Nama_Pembeli = $data['Nama_Pembeli'];

        $query = $db->prepare('SET @P2=""; CALL tambah_pembeli(:id_pembeli_param, :Nama_Pembeli_param, @P2)');
        $query->bindParam(':id_pembeli_param', $id_pembeli, PDO::PARAM_INT);
        $query->bindParam(':Nama_Pembeli_param', $Nama_Pembeli, PDO::PARAM_STR);

        $query->execute();
        $response->getBody()->write(json_encode([
            'message'=> 'Berhasil menambahkan pembeli'
        ]));
        return $response->withHeader("Content-Type", "application/json");
    });


    //post data kasir
    $app->post("/kasir", function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $data = $request->getParsedBody();
        $id_kasir = $data['id_kasir'];
        $Nama_Kasir = $data['Nama_Kasir'];

        $query = $db->prepare('SET @P2=""; CALL tambah_kasir(:id_kasir_param, :Nama_Kasir_param, @P2)');
        $query->bindParam(':id_kasir_param', $id_kasir, PDO::PARAM_INT);
        $query->bindParam(':Nama_Kasir_param', $Nama_Kasir, PDO::PARAM_STR);

        $query->execute();
        $response->getBody()->write(json_encode([
            'message'=> 'Berhasil menambahkan kasir'
        ]));
        return $response->withHeader("Content-Type", "application/json");
    });

    //post data transaksi
    $app->post("/transaksi", function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $data = $request->getParsedBody();
        $id_transaksi = $data['id_transaksi'];
        $id_menu_transaksi = $data['id_menu_transaksi'];
        $id_pembeli = $data['id_pembeli'];
        $id_kasir = $data['id_kasir'];
        $tanggal_transaksi = $data['tanggal_transaksi'];
        $no_transaksi = $data['no_transaksi'];

        $query = $db->prepare('SET @P6=""; CALL tambah_transaksi(:id_transaksi_param, :id_menu_transaksi_param, :id_pembeli_param, :id_kasir_param, :tanggal_transaksi_param, :no_transaksi_param, @P6)');
        $query->bindParam(':id_transaksi_param', $id_transaksi, PDO::PARAM_INT);
        $query->bindParam(':id_menu_transaksi_param', $id_menu_transaksi, PDO::PARAM_INT);
        $query->bindParam(':id_pembeli_param', $id_pembeli, PDO::PARAM_INT);
        $query->bindParam(':id_kasir_param', $id_kasir, PDO::PARAM_INT);
        $query->bindParam(':tanggal_transaksi_param', $tanggal_transaksi, PDO::PARAM_STR);
        $query->bindParam(':no_transaksi_param', $no_transaksi, PDO::PARAM_STR);

        $query->execute();
        $response->getBody()->write(json_encode([
            'message'=> 'Berhasil menambahkan transaksi'
        ]));
        return $response->withHeader("Content-Type", "application/json");
    });

    
   // put data menu
    $app->put('/menu/{menu_id}', function(Request $request, Response $response, $args) {
        echo'test';
        $db = $this->get(PDO::class);
        $id = $args['menu_id']; // Menggunakan 'id_barang' sesuai dengan yang Anda definisikan dalam rute
        $parsedBody = $request->getParsedBody();
        
        $newName = isset($parsedBody['new_Nama_Menu']) ? $parsedBody['new_Nama_Menu'] : null;
        $newHarga = isset($parsedBody['new_harga']) ? $parsedBody['new_harga'] : null;
    
        if ($newName === null && $newHarga === null) {
            $response->getBody()->write(json_encode(
                [
                    'error' => 'Tidak ada data yang diperbarui.'
                ]
            ));
            return $response->withStatus(400); // Atur status kode ke 400 Bad Request atau sesuai kebutuhan
        } try {
            $query = $db->prepare('CALL Update_menu(?, ?, ? )');
            $query->bindParam(1, $id, PDO::PARAM_STR);
            $query->bindParam(2, $newName, PDO::PARAM_STR);
            $query->bindParam(3, $newHarga, PDO::PARAM_STR);
        
            $query->execute();
        
            $response->getBody()->write(json_encode(
                [
                    'message' => 'menu dengan id ' . $id . ' telah diperbarui'
                ]
            ));
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(
                [
                    'error' => 'Gagal memperbarui menu: ' . $e->getMessage()
                ]
            ));
        }
        return $response->withHeader("Content-Type", "application/json");
    });

    //put data kasir
    $app->put('/kasir/{kasir_id}', function (Request $request, Response $response, $args) {
        echo'test';
        $db = $this->get(PDO::class);
        $id = $args['kasir_id']; // Menggunakan 'id_barang' sesuai dengan yang Anda definisikan dalam rute
        $parsedBody = $request->getParsedBody();

        $newName = isset($parsedBody['new_Nama_Kasir']) ? $parsedBody['new_Nama_Kasir'] : null;

        if ($newName === null) {
            $response->getBody()->write(json_encode(
                [
                    'error'=> 'Tidak ada data yang diperbarui.'
                ]
            ));
            return $response->withStatus(400); // Atur status kode ke 400 Bad Request atau sesuai kebutuhan
        } try {
            $query = $db->prepare('CALL Update_kasir(?, ?)');
            $query->bindParam(1, $id, PDO::PARAM_STR);
            $query->bindParam(2, $newName, PDO::PARAM_STR);

            $query->execute();

            $response->getBody()->write(json_encode(
                [
                    'message' => 'kasir dengan id ' . $id . ' telah diperbarui'
                ]
            ));
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(
                [
                    'error' => 'Gagal memperbarui kasir: ' . $e->getMessage()
                ]
            ));
        }
        return $response->withHeader("Content-Type", "application/json");
    });

    //put data pembeli
    $app->put('/pembeli/{pembeli_id}', function (Request $request, Response $response, $args) {
        echo'test';
        $db = $this->get(PDO::class);
        $id = $args['pembeli_id']; // Menggunakan 'id_barang' sesuai dengan yang Anda definisikan dalam rute
        $parsedBody = $request->getParsedBody();

        $newName = isset($parsedBody['new_Nama_Pembeli']) ? $parsedBody['new_Nama_Pembeli'] : null;

        if ($newName === null) {
            $response->getBody()->write(json_encode(
                [
                    'error'=> 'Tidak ada data yang diperbarui.'
                ]
            ));
            return $response->withStatus(400); // Atur status kode ke 400 Bad Request atau sesuai kebutuhan
        } try {
            $query = $db->prepare('CALL Update_pembeli(?, ?)');
            $query->bindParam(1, $id, PDO::PARAM_STR);
            $query->bindParam(2, $newName, PDO::PARAM_STR);

            $query->execute();

            $response->getBody()->write(json_encode(
                [
                    'message' => 'pembeli dengan id ' . $id . ' telah diperbarui'
                ]
            ));
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(
                [
                    'error' => 'Gagal memperbarui pembeli: ' . $e->getMessage()
                ]
            ));
        }
        return $response->withHeader("Content-Type", "application/json");
    });

    // put data menu transaksi
    $app->put('/menu_transaksi/{menu_transaksi_id}', function(Request $request, Response $response, $args) {
        echo'test';
        $db = $this->get(PDO::class);
        $id = $args['menu_transaksi_id']; // Menggunakan 'id_barang' sesuai dengan yang Anda definisikan dalam rute
        $parsedBody = $request->getParsedBody();
        
        $newjumlah_menu_transaksi = isset($parsedBody['new_jumlah_menu_transaksi']) ? $parsedBody['new_jumlah_menu_transaksi'] : null;
    
        if ($newjumlah_menu_transaksi === null) {
            $response->getBody()->write(json_encode(
                [
                    'error' => 'Tidak ada data yang diperbarui.'
                ]
            ));
            return $response->withStatus(400); // Atur status kode ke 400 Bad Request atau sesuai kebutuhan
        } try {
            $query = $db->prepare('CALL Update_menu_transaksi(?, ?, ? )');
            $query->bindParam(1, $id, PDO::PARAM_STR);
            $query->bindParam(2, $id, PDO::PARAM_STR);
            $query->bindParam(3, $newjumlah_menu_transaksi, PDO::PARAM_STR);
        
            $query->execute();
        
            $response->getBody()->write(json_encode(
                [
                    'message' => 'menu transaksi dengan id ' . $id . ' telah diperbarui'
                ]
            ));
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(
                [
                    'error' => 'Gagal memperbarui menu transaksi: ' . $e->getMessage()
                ]
            ));
        }
        return $response->withHeader("Content-Type", "application/json");
    });

    // put data transaksi
    $app->put('/transaksi/{transaksi_id}', function(Request $request, Response $response, $args) {
        echo'test';
        $db = $this->get(PDO::class);
        $id = $args['transaksi_id']; // Menggunakan 'id_barang' sesuai dengan yang Anda definisikan dalam rute
        $parsedBody = $request->getParsedBody();
        
        $newtanggal_transaksi = isset($parsedBody['new_tanggal_transaksi']) ? $parsedBody['new_tanggal_transaksi'] : null;
        $newno_transaksi = isset($parsedBody['new_no_transaksi']) ? $parsedBody['new_no_transaksi'] : null;
    
        if ($newtanggal_transaksi === null && $newno_transaksi != null) {
            $response->getBody()->write(json_encode(
                [
                    'error' => 'Tidak ada data yang diperbarui.'
                ]
            ));
            return $response->withStatus(400); // Atur status kode ke 400 Bad Request atau sesuai kebutuhan
        } try {
            $query = $db->prepare('CALL Update_transaksi(?, ?, ?, ?, ?, ? )');
            $query->bindParam(1, $id, PDO::PARAM_STR);
            $query->bindParam(2, $id, PDO::PARAM_STR);
            $query->bindParam(3, $id, PDO::PARAM_STR);
            $query->bindParam(4, $id, PDO::PARAM_STR);
            $query->bindParam(5, $newtanggal_transaksi, PDO::PARAM_STR);
            $query->bindParam(6, $newno_transaksi, PDO::PARAM_STR);
        
            $query->execute();
        
            $response->getBody()->write(json_encode(
                [
                    'message' => 'transaksi dengan id ' . $id . ' telah diperbarui'
                ]
            ));
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(
                [
                    'error' => 'Gagal memperbarui menu transaksi: ' . $e->getMessage()
                ]
            ));
        }
        return $response->withHeader("Content-Type", "application/json");
    });

    
    // delete data menu
    $app->delete('/menu/{menu_id}', function(Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);
        $id = $args['menu_id'];
    
        try {
            $query = $db->prepare('CALL Hapus_menu(?)');
            $query->bindParam(1, $id, PDO::PARAM_STR);
    
            $query->execute();
    
            $response->getBody()->write(json_encode(
                [
                    'message' => 'menu dengan id ' . $id . ' telah dihapus'
                ]
            ));
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(
                [
                    'error' => 'menu detail pesanan: ' . $e->getMessage()
                ]
            ));
        }
        return $response->withHeader("Content-Type", "application/json");
    });

    //delete data kasir
    $app->delete('/kasir/{kasir_id}', function(Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);
        $id = $args['kasir_id'];
    
        try {
            $query = $db->prepare('CALL Hapus_kasir(?)');
            $query->bindParam(1, $id, PDO::PARAM_STR);
    
            $query->execute();
    
            $response->getBody()->write(json_encode(
                [
                    'message' => 'kasir dengan id ' . $id . ' telah dihapus'
                ]
            ));
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(
                [
                    'error' => ' detail data kasir  : ' . $e->getMessage()
                ]
            ));
        }
        return $response->withHeader("Content-Type", "application/json");
    });

    //delete data pembeli
    $app->delete('/pembeli/{pembeli_id}', function(Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);
        $id = $args['pembeli_id'];
    
        try {
            $query = $db->prepare('CALL Hapus_pembeli(?)');
            $query->bindParam(1, $id, PDO::PARAM_STR);
    
            $query->execute();
    
            $response->getBody()->write(json_encode(
                [
                    'message' => 'pembeli dengan id ' . $id . ' telah dihapus'
                ]
            ));
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(
                [
                    'error' => ' detail data pembeli  : ' . $e->getMessage()
                ]
            ));
        }
        return $response->withHeader("Content-Type", "application/json");
    });

     //delete data menu transaksi
     $app->delete('/menu_transaksi/{menu_transaksi_id}', function(Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);
        $id = $args['menu_transaksi_id'];
    
        try {
            $query = $db->prepare('CALL Hapus_menu_transaksi(?)');
            $query->bindParam(1, $id, PDO::PARAM_STR);
    
            $query->execute();
    
            $response->getBody()->write(json_encode(
                [
                    'message' => 'menu transaksi dengan id ' . $id . ' telah dihapus'
                ]
            ));
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(
                [
                    'error' => ' detail data menu transaksi  : ' . $e->getMessage()
                ]
            ));
        }
        return $response->withHeader("Content-Type", "application/json");
    });

     //delete data transaksi
     $app->delete('/transaksi/{transaksi_id}', function(Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);
        $id = $args['transaksi_id'];
    
        try {
            $query = $db->prepare('CALL Hapus_transaksi(?)');
            $query->bindParam(1, $id, PDO::PARAM_STR);
    
            $query->execute();
    
            $response->getBody()->write(json_encode(
                [
                    'message' => 'transaksi dengan id ' . $id . ' telah dihapus'
                ]
            ));
        } catch (PDOException $e) {
            $response->getBody()->write(json_encode(
                [
                    'error' => ' detail data transaksi  : ' . $e->getMessage()
                ]
            ));
        }
        return $response->withHeader("Content-Type", "application/json");
    });



};
