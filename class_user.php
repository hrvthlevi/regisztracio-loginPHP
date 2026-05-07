<?php
	class User{
		private $host="";
    
		//konstuktor
		public function __construct() {
		try {
        $this->kapcsolat = new mysqli(
            $this->host,
        );

        $this->kapcsolat->set_charset("utf8mb4");

		} catch (mysqli_sql_exception $e) {
			throw new Exception(
				"Adatbázis kapcsolódási hiba: " . $e->getMessage(),
				$e->getCode() );
			}
		}

				
		public function reg_felhasznalo($nev, $email, $jelszo){
			$jelszo = md5($jelszo);
			...

			//ha nem regisztrált, létrehozzuk user jog-gal
			if (...){
				$stmt=$this->kapcsolat->prepare("SQL INSERT");
				$stmt->bind_param("sss", $nev, $email, $jelszo);
				return $stmt->execute();
			}
			else { 
				return false;}
		}

		
		public function bejelentkezes($emailNev, $jelszo){

        	$titkosJelszo = md5($jelszo);
			$sql="";
			
			//ha regisztrált, beléptetjük...
	        if (...) {
	            // session beállítása
	            $_SESSION['login'] = true;
				$user_data = $result->fetch_array(MYSQLI_ASSOC);
				$felhAzon = $user_data['felhAzon'];
	            $_SESSION['felhAzon'] = $felhAzon;
				//megváltoztatjuk a bejelentkezett mező értékét
				$sql="";
				...
	            return true;
	        }
	        else{
			    return false;
			}
    	}

    	/*név lekérése*/
    	public function get_nev($felhAzon){
    		$sql="SELECT nev FROM felhasznalo WHERE felhAzon = $felhAzon";
	        $result = ...;
	        $user_data = $result->fetch_array(MYSQLI_ASSOC);
	        echo $user_data['nev'];
    	}
		
		public function isAdmin($felhAzon){
    		$sql="SELECT ...";
	        $result = ...;
	        if ($result == 1){return true;}
			return false;
    	}

    	/*** be van-e jelentkezve ***/
	    public function get_session(){
	        return $_SESSION['login'] ?? false;
	    }

	    public function kijelentkezes() {
			$felhAzon = $_SESSION['felhAzon'];
			$sql="...";
			$result = ...;
			//ezek maradjanak: munkamenet megszüntetése
	        $_SESSION = [];
			session_destroy();
	    }
		
		public function aktivok(){
			$sql = "...";
			return ...;
		}
		
		public function megjelenit_aktivok($matrix){
			...;
		}

		
	}
?>