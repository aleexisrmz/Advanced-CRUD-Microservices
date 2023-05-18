<?php    
     namespace ClaseSw;
    class DB {
        private $project;

        public function __construct($project) {
                $this->project = $project;
        }
        private function deleteProductos($categoria, $document) {
            $url = 'https://'.$this->project.'.firebaseio.com/detalles/'.$document.'.json';
        
            $ch =  curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
            $response = curl_exec($ch);
        
            // Si no se obtuvieron resultados, entonces no existe la colección
            if( is_null(json_decode($response)) ) {
                $resBool =  false;
            } else {    // Si existe la colección, entnces se procede a eliminar la colección
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" ); 
                curl_exec($ch);
                $resBool =  true;
            }
            
            curl_close($ch);
        
            // Se devuelve true o false
            return $resBool;
        }
        private function deleteProducto($categoria, $document) {
            $url = 'https://'.$this->project.'.firebaseio.com/productos/'.$categoria.'/'.$document.'.json';
        
            $ch =  curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
            $response = curl_exec($ch);
        
            // Si no se obtuvieron resultados, entonces no existe la colección
            if( is_null(json_decode($response)) ) {
                $resBool =  false;
            } else {    // Si existe la colección, entnces se procede a eliminar la colección
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE" ); 
                curl_exec($ch);
                $resBool =  true;
            }
            
            curl_close($ch);
        
            // Se devuelve true o false
            return $resBool;
        }
        private function createProducto($categoria,$document){
            $url = 'https://'.$this->project.'.firebaseio.com/productos/'.$categoria.'/'.'.json';

            $ch =  curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH" );  // en sustitución de curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $document);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
            $response = curl_exec($ch);
        
            curl_close($ch);
        
            // Se convierte a Object o NULL
            return json_decode($response);

        }
        private function createProductoDetalles($document){
            $url = 'https://'.$this->project.'.firebaseio.com/detalles/'.'.json';

            $ch =  curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH" );  // en sustitución de curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $document);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
            $response = curl_exec($ch);
        
            curl_close($ch);
        
            // Se convierte a Object o NULL
            return json_decode($response);

        }
        private function runCurl($collection, $document) {
            $url = 'https://'.$this->project.'.firebaseio.com/'.$collection.'/'.$document.'.json';
            $ch =  curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
            $response = curl_exec($ch);
        
            curl_close($ch);
        
            // Se convierte a Object o NULL
            return json_decode($response);
        }
        public function isUser($name) {
            if( !is_null( $this->runCurl('usuarios',$name))) {
               return true;
            } else {
                return false;
            }
        }
        public function obtainPass($user) {
            return $this->runCurl('usuarios',$user);

       } 
       public function isCategoryDB($categoria){
           
           if(!is_null($this->runCurl('productos',$categoria))) {
              return true;
           } else {
               return false;
           }
       }
        public function obtainProduc($categoria){
         return $this->runCurl('productos',$categoria);

        }
        public function isIsbnDd($clave) {
            
            if(!is_null($this->runCurl('detalles',$clave))) {
                return true;
            } else {
                return false;
            }
        }
        public function isIsbnDdV2($clave){
            
            if(!is_null($this->runCurl('detalles',$clave))) {
                return false;
            } else {
                return true;
            }
        }
        public function obtainDetails($isbn){
            return $this->runCurl('detalles',$isbn);
        }
        public function obtainMessage($code){
        return $this->runCurl('respuestas',$code);
        }
        public function setProducto($categoria,$data){
            
            
            if( !is_null($this->createProducto($categoria,$data)) ) {
                return false;
                // '<br>Insersión exitosa<br>';
            } else {
                return true;
                // '<br>Insersión fallida<br>';
            }
        }
        public function setProductoDetalles($data){
            
            
            if( !is_null($this->createProductoDetalles($data)) ) {
                return false;
                // '<br>Insersión exitosa<br>';
            } else {
                return true;
                // '<br>Insersión fallida<br>';
            }
        }
        public function deleteProd($categoria,$data){
            
            
            if( $this->deleteProducto($categoria,$data)){
                if($this->deleteProductos($categoria,$data)){
                    return true;
                }
                
                // '<br>Insersión exitosa<br>';
            } else {
                return false    ;
                // '<br>Insersión fallida<br>';
            }
        }

        public function createUsuario($document){
            $url = 'https://'.$this->project.'.firebaseio.com/usuario_sistema/'.'.json';

            $ch =  curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH" );  // en sustitución de curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $document);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
            $response = curl_exec($ch);
        
            curl_close($ch);
        
            // Se convierte a Object o NULL
            return json_decode($response);

        }
        public function setUsuario($data){
            
            
            if( !is_null($this->createUsuario($data)) ) {
                return false;
                // '<br>Insersión exitosa<br>';
            } else {
                return true;
                // '<br>Insersión fallida<br>';
            }
        }
        public function isUserDB($name) {
            if( !is_null( $this->runCurl('usuario_sistema',$name))) {
               return true;
            } else {
             return false;
            }
        }
        public function obtainUsuarios($categoria){
            return $this->runCurl('usuario_sistema',$categoria);
    
            }

        }
