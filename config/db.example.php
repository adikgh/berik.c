<?
	// Сатылым сайтының базасы: осы файлды db.php деп көшіріп, деректерді жазыңыз (db.php git-ке кірмейді).
	// Тіркелу формасы осы базаға компания ашады, сондықтан админ мен кассамен БІР база болуы керек.
	class db {
		public static $host = 'localhost';
		public static $user = 'root';
		public static $pass = '';
		public static $name = 'berik_005';
		public static $connect = null;

		public function __construct() {
			self::$connect = @mysqli_connect(self::$host, self::$user, self::$pass, self::$name);
			if (self::$connect) @mysqli_set_charset(self::$connect, 'utf8mb4');
		}
		public static function query($sql) { return mysqli_query(self::$connect, $sql); }
	}
