<?php
/**
 * Class Bit_LD_Emails
 */
if ( ! class_exists( 'Bit_LD_Emails' ) ) {
	class Bit_LD_Emails {
		private static $ins = null;

		private $id = 0;
		private $student_id = 0;
		private $student_first_name = '';
		private $student_last_name = '';
		private $student_email = '';
		private $parent_id = 0;
		private $parent_first_name = '';
		private $parent_last_name = '';
		private $parent_email = '';
		private $event_id = 0;
		private $trigger_type = '';
		private $creation_time = 0;
		private $sent_time = 0;

		private $bit_conn = null;
		private $table_name = '';
		private $table_prefix = '';

		/**
		 * Bit_LD_Emails constructor.
		 */
		public function __construct() {
			$this->table_prefix = 'bit_';
			$this->table_name   = 'ld_email_triggers';
			$this->bit_conn     = $this->get_connection();
		}

		/**
		 * @return Bit_LD_Emails|null
		 */
		public static function get_instance() {
			if ( null === self::$ins ) {
				self::$ins = new self;
			}

			return self::$ins;
		}

		public function set_id( $id ) {
			$this->id = $id;
		}

		public function set_student_id( $student_id ) {
			$this->student_id = $student_id;
		}

		public function set_student_first_name( $student_first_name ) {
			$this->student_first_name = $student_first_name;
		}

		public function set_student_last_name( $student_last_name ) {
			$this->student_last_name = $student_last_name;
		}

		public function set_student_email( $student_email ) {
			$this->student_email = $student_email;
		}

		public function set_parent_id( $parent_id ) {
			$this->parent_id = $parent_id;
		}

		public function set_parent_first_name( $parent_first_name ) {
			$this->parent_first_name = $parent_first_name;
		}

		public function set_parent_last_name( $parent_last_name ) {
			$this->parent_last_name = $parent_last_name;
		}

		public function set_parent_email( $parent_email ) {
			$this->parent_email = $parent_email;
		}

		public function set_event_id( $event_id ) {
			$this->event_id = $event_id;
		}

		public function set_trigger_type( $trigger_type ) {
			$this->trigger_type = $trigger_type;
		}

		public function set_creation_time( $creation_time ) {
			$this->creation_time = $creation_time;
		}

		public function set_sent_time( $sent_time ) {
			$this->sent_time = $sent_time;
		}

		public function get_id() {
			return $this->id;
		}

		public function get_student_id() {
			return $this->student_id;
		}

		public function get_student_first_name() {
			return $this->student_first_name;
		}

		public function get_student_last_name() {
			return $this->student_last_name;
		}

		public function get_student_email() {
			return $this->student_email;
		}

		public function get_parent_id() {
			return $this->parent_id;
		}

		public function get_parent_first_name() {
			return $this->parent_first_name;
		}

		public function get_parent_last_name() {
			return $this->parent_last_name;
		}

		public function get_parent_email() {
			return $this->parent_email;
		}

		public function get_event_id() {
			return $this->event_id;
		}

		public function get_trigger_type() {
			return $this->trigger_type;
		}

		public function get_creation_time() {
			return $this->creation_time;
		}

		public function get_sent_time() {
			return $this->sent_time;
		}

		public function save( $setData = array() ) {
			foreach ( is_array( $setData ) ? $setData : array() as $s_key => $s_value ) {
				$this->{$s_key} = $s_value;
			}

			$student_id = $this->get_student_id();

			$data                       = array();
			$data['student_id']         = $student_id;
			$data['student_first_name'] = empty( $this->get_student_first_name() ) ? 'NA' : $this->get_student_first_name();
			$data['student_last_name']  = $this->get_student_last_name();
			$data['student_email']      = $this->get_student_email();
			$data['parent_id']          = $this->get_parent_id();
			$data['parent_first_name']  = empty( $this->get_parent_first_name() ) ? 'NA' : $this->get_parent_first_name();
			$data['parent_last_name']   = $this->get_parent_last_name();
			$data['parent_email']       = $this->get_parent_email();
			$data['event_id']           = empty( $this->get_event_id() ) ? 0 : $this->get_event_id();
			$data['trigger_type']       = $this->get_trigger_type();
			$data['creation_time']      = $this->get_creation_time();
			$data['sent_time']          = empty( $this->get_sent_time() ) ? 0 : $this->get_sent_time();

			if ( $this->bit_conn instanceof mysqli ) {

				$columns        = implode( ", ", array_keys( $data ) );
				$escaped_values = array_values( $data );
				$values         = implode( ", ", $escaped_values );
				$table_name     = $this->table_prefix . $this->table_name;
				$final_sql      = "INSERT INTO `$table_name` ($columns) VALUES ($values)";

				echo $final_sql;

				$this->bit_conn->query( $final_sql );
				$message = "Inserted data for student id: $student_id";

				echo "<br>" . $message;

				if ( ! empty( $this->bit_conn->error ) ) {
					echo '<br>Error: ';
					print_r( $this->bit_conn->error );
				}
			}
		}


		public function get_connection() {
			$conn = new mysqli( "localhost", "root", "", "bitwise" );
			// Check connection
			if ( $conn->connect_errno ) {
				echo "Failed to connect to MySQL: " . $conn->connect_error;
				exit();
			}

			return $conn;
		}

		public function setup_emails() {
			$point_sql     = "SELECT * from " . $this->table_prefix . 'points_leader' . " ORDER BY `id` ASC";
			$point_results = $this->bit_conn->query( $point_sql );
			echo "<pre>";
			print_r( $point_results );

			if ( $point_results->num_rows > 0 ) {
				$point_rank = 1;
				while ( $row = $point_results->fetch_assoc() ) {
					//print_r($row);
					if ( 'course_completed' === $row['last_event'] ) {
						$this->set_student_id( $row['student_id'] );
						$this->set_student_first_name( $row['student_first_name'] );
						$this->set_student_last_name( $row['student_last_name'] );
						$this->set_student_email( $row['student_email'] );
						$this->set_parent_id( $row['parent_id'] );
						$this->set_parent_first_name( $row['parent_first_name'] );
						$this->set_parent_last_name( $row['parent_last_name'] );
						$this->set_parent_email( $row['parent_email'] );
						$this->set_event_id( $row['last_event_id'] );
						$this->set_trigger_type( $row['last_event'] );
						$this->set_creation_time( $row['last_added'] );
						$this->set_sent_time( 0 );
						$this->save();
					}
				}
			}
		}


		public function create_table() {
			$collate = "DEFAULT CHARACTER SET utf8";
			$sql     = "CREATE TABLE IF NOT EXISTS `" . $this->table_prefix . $this->table_name . "` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`student_id` INT(6) UNSIGNED NOT NULL,
				`student_first_name` VARCHAR(50) NOT NULL,
				`student_last_name` VARCHAR(50),
				`student_email` VARCHAR(100) NOT NULL,
				`parent_id` INT(6) UNSIGNED NOT NULL,
				`parent_first_name` VARCHAR(50) NOT NULL,
				`parent_last_name` VARCHAR(50),
				`parent_email` VARCHAR(100) NOT NULL,
				`event_id` INT(6) UNSIGNED,
				`trigger_type` VARCHAR(100) NOT NULL,
				`creation_time` BIGINT(20) UNSIGNED NOT NULL,
				`sent_time` BIGINT(20) UNSIGNED,
				PRIMARY KEY (`id`),
				KEY `id` (`id`)
                ) " . $collate . ";";

			$result = $this->bit_conn->query( $sql );
			echo "Table created: ";
			print_r( $result );
		}
	}

	$bit_ld_emails = Bit_LD_Emails::get_instance();
	$bit_ld_emails->create_table();
	$bit_ld_emails->setup_emails();
}