<?php
/**
 * Class Bit_LD_Email_Tracing
 */
if ( ! class_exists( 'Bit_LD_Email_Tracing' ) ) {
	class Bit_LD_Email_Tracing {
		private static $ins = null;

		private $id = 0;
		private $student_id = 0;
		private $trigger_type = '';
		private $setup_time = 0;

		private $bit_conn = null;
		private $table_name = '';
		private $table_prefix = '';

		/**
		 * Bit_LD_Email_Tracing constructor.
		 */
		public function __construct() {
			$this->table_prefix = 'bit_';
			$this->table_name   = 'ld_email_tracing';
		}

		/**
		 * @return Bit_LD_Email_Tracing|null
		 */
		public static function get_instance() {
			if ( null === self::$ins ) {
				self::$ins = new self;
			}

			return self::$ins;
		}

		/**
		 * Setter function for email trigger id
		 *
		 * @param $id
		 */
		public function set_id( $id ) {
			$this->id = $id;
		}

		/**
		 * Setter function for student id
		 *
		 * @param $student_id
		 */
		public function set_student_id( $student_id ) {
			$this->student_id = $student_id;
		}

		/**
		 * Setter function for trigger_type
		 *
		 * @param $trigger_type
		 */
		public function set_trigger_type( $trigger_type ) {
			$this->trigger_type = $trigger_type;
		}

		/**
		 * Setter function for setup_time
		 *
		 * @param $setup_time
		 */
		public function set_setup_time( $setup_time ) {
			$this->setup_time = $setup_time;
		}

		/**
		 * Getter function for email trigger id
		 * @return int
		 */
		public function get_id() {
			return $this->id;
		}

		/**
		 * Getter function for student_id
		 * @return int
		 */
		public function get_student_id() {
			return $this->student_id;
		}

		/**
		 * Getter function for trigger_type
		 * @return string
		 */
		public function get_trigger_type() {
			return $this->trigger_type;
		}

		/**
		 * Getter function for setup_time
		 * @return int
		 */
		public function get_setup_time() {
			return $this->setup_time;
		}

		/**
		 * Save the email traces, insert a new row or update if already exist
		 *
		 * @param array $setData
		 */
		public function save( $setData = array() ) {
			foreach ( is_array( $setData ) ? $setData : array() as $s_key => $s_value ) {
				$this->{$s_key} = $s_value;
			}

			$student_id = intval( $this->get_student_id() );

			$data                 = array();
			$data['student_id']   = $student_id;
			$data['trigger_type'] = $this->get_trigger_type();
			$data['setup_time']   = empty( $this->get_setup_time() ) ? 0 : $this->get_setup_time();

			if ( $this->bit_conn instanceof mysqli ) {
				$columns      = implode( ", ", array_keys( $data ) );
				$values       = array_values( $data );
				$final_values = '';
				$count        = count( $values );
				foreach ( $values as $key => $value ) {
					$final_values .= "'" . $value . "'";
					if ( $key < $count - 1 ) {
						$final_values .= ",";
					}
				}

				$updated    = false;
				$table_name = $this->table_prefix . $this->table_name;

				$student_sql     = "SELECT * FROM " . $table_name . " WHERE `student_id`=$student_id AND `trigger_type`='inactive_student'";
				$student_results = $this->bit_conn->query( $student_sql );

				$final_sql = "INSERT INTO $table_name ($columns) VALUES ( $final_values)";
				if ( $student_results->num_rows > 0 ) {
					$updated   = true;
					$final_sql = "UPDATE `$table_name` SET `setup_time`=" . $data['setup_time'] . " WHERE `student_id`=$student_id";
				}

				if ( ! empty( $final_sql ) ) {
					$result = $this->bit_conn->query( $final_sql );
					if ( ! $result ) {
						echo '<br>Error: ';
						print_r( $result );
						echo "</br>";
					}
				}

				$message = "Data for student id: $student_id is ";
				if ( $updated ) {
					$message .= "updated";
				} else {
					$message .= "inserted";
				}
				$message .= " in the table " . $table_name;

				echo "<br>" . $message;

				if ( ! empty( $this->bit_conn->error ) ) {
					echo '<br>Error: ';
					print_r( $this->bit_conn->error );
				}
			}
		}


		/**
		 * Recording an event trace
		 *
		 * @param $data
		 */
		public function record_trace( $data ) {
			$this->set_student_id( $data['student_id'] );
			$this->set_trigger_type( $data['trigger_type'] );
			$this->set_setup_time( $data['creation_time'] );
			$this->save();
		}

		/**
		 * @param $student_id
		 *
		 * @return false
		 */
		public function need_to_record( $student_id ) {
			$table_name = $this->table_prefix . $this->table_name;
			$one_week_ago      = strtotime( "-6 days" );
			$student_sql       = "SELECT `setup_time` FROM " . $table_name . " WHERE `student_id`=$student_id AND `trigger_type`='inactive_student'";
			$student_results   = $this->bit_conn->query( $student_sql );
			if ( $student_results->num_rows > 0 ) {
				while ( $row = $student_results->fetch_array() ) {
					$last_updated_time = $row['setup_time'];
					return ( $last_updated_time > $one_week_ago );
				}
			}

			return true;
		}

		/**
		 * Creating email tracing table
		 */
		public function create_table( $bit_connection ) {
			$this->bit_conn = $bit_connection;

			$collate = "DEFAULT CHARACTER SET utf8";
			$sql     = "CREATE TABLE IF NOT EXISTS `" . $this->table_prefix . $this->table_name . "` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`student_id` INT(6) UNSIGNED NOT NULL,
				`trigger_type` VARCHAR(100) NOT NULL,				
				`setup_time` BIGINT(20) UNSIGNED,
				PRIMARY KEY (`id`),
				KEY `id` (`id`)
                ) " . $collate . ";";

			$result = $this->bit_conn->query( $sql );
			echo "<br>Table $this->table_name has been created. </br>";
			if ( ! $result ) {
				echo "Error in the table $this->table_name creation: ";
				print_r( $result );
			}
		}
	}
}
