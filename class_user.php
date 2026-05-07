<?php
class User
{
	private $host = "";
	private $felhasznalo = "root";
	private $jelszo = "";
	private $ab = "pizzahot";
	private $kapcsolat;

	//konstruktor
	public function __construct()
	{
		try {
			$this->kapcsolat = new mysqli(
				$this->host,
				$this->felhasznalo,
				$this->jelszo,
				$this->ab
			);

			$this->kapcsolat->set_charset("utf8mb4");
		} catch (mysqli_sql_exception $e) {
			throw new Exception(
				"Adatbázis kapcsolódási hiba: " . $e->getMessage(),
				$e->getCode()
			);
		}
	}


	public function reg_felhasznalo($nev, $email, $jelszo)
	{

		$jelszo = md5($jelszo);

		$sql = "SELECT * FROM felhasznalo WHERE email='$email'";

		$eredmeny = $this->kapcsolat->query($sql);

		$sorokSzama = $eredmeny->num_rows;

		// ha nem regisztrált
		if ($sorokSzama == 0) {

			$stmt = $this->kapcsolat->prepare(
				"INSERT INTO felhasznalo 
            (jogAzon, nev, email, jelszo, bejelentkezett) 
            VALUES (2, ?, ?, ?, 0)"
			);

			$stmt->bind_param("sss", $nev, $email, $jelszo);

			return $stmt->execute();
		} else {

			return false;
		}
	}

	public function bejelentkezes($emailNev, $jelszo)
	{

		$titkosJelszo = md5($jelszo);

		$sql = "SELECT * FROM felhasznalo 
            WHERE (email='$emailNev' OR nev='$emailNev') 
            AND jelszo='$titkosJelszo'";

		$eredmeny = $this->kapcsolat->query($sql);

		$sorokSzama = $eredmeny->num_rows;

		// ha regisztrált, beléptetjük
		if ($sorokSzama == 1) {

			// session beállítása
			$_SESSION['login'] = true;

			$user_data = $eredmeny->fetch_array(MYSQLI_ASSOC);

			$felhAzon = $user_data['felhAzon'];

			$_SESSION['felhAzon'] = $felhAzon;
			$_SESSION['felhasznaloNev'] = $user_data['nev'];

			$sql = "UPDATE felhasznalo 
                SET bejelentkezett = 1 
                WHERE felhAzon = $felhAzon";

			$this->kapcsolat->query($sql);

			return true;
		} else {

			return false;
		}
	}

	/*név lekérése*/
	public function get_nev($felhAzon)
	{
		$sql = "SELECT nev FROM felhasznalo WHERE felhAzon = $felhAzon";
		$result = $this->kapcsolat->query($sql);
		$user_data = $result->fetch_array(MYSQLI_ASSOC);
		return $user_data['nev'];
	}

public function isAdmin($felhAzon)
{
    $sql = "SELECT j.nev FROM felhasznalo f 
            INNER JOIN jogosultsag j ON f.jogAzon = j.jogAzon 
            WHERE f.felhAzon = $felhAzon";
    $result = $this->kapcsolat->query($sql);
    $user_data = $result->fetch_array(MYSQLI_ASSOC);
    if ($user_data['nev'] == 'admin') {
        return true;
    }
    return false;
}

	/*** be van-e jelentkezve ***/
	public function get_session()
	{
		return $_SESSION['login'] ?? false;
	}

	public function kijelentkezes()
	{
		$felhAzon = $_SESSION['felhAzon'];
		$sql = "UPDATE felhasznalo SET bejelentkezett = 0 WHERE felhAzon = $felhAzon";
		$this->kapcsolat->query($sql);
		$_SESSION = [];
		session_destroy();
	}
	public function aktivok()
	{
		$sql = "SELECT nev FROM felhasznalo WHERE bejelentkezett = 1";
		return $this->kapcsolat->query($sql);
	}

	public function megjelenit_aktivok($matrix)
	{
		echo "<ul>";
		while ($sor = $matrix->fetch_row()) {
			echo "<li>$sor[0]</li>";
		}
		echo "</ul>";
	}
}
