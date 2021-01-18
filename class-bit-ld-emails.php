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
		private $email_priority = 0;
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
		 * Setter function for student_first_name
		 *
		 * @param $student_first_name
		 */
		public function set_student_first_name( $student_first_name ) {
			$this->student_first_name = $student_first_name;
		}

		/**
		 * Setter function for student_last_name
		 *
		 * @param $student_last_name
		 */
		public function set_student_last_name( $student_last_name ) {
			$this->student_last_name = $student_last_name;
		}

		/**
		 * Setter function for student_email
		 *
		 * @param $student_email
		 */
		public function set_student_email( $student_email ) {
			$this->student_email = $student_email;
		}

		/**
		 * Setter function for parent_id
		 *
		 * @param $parent_id
		 */
		public function set_parent_id( $parent_id ) {
			$this->parent_id = $parent_id;
		}

		/**
		 * Setter function for parent_first_name
		 *
		 * @param $parent_first_name
		 */
		public function set_parent_first_name( $parent_first_name ) {
			$this->parent_first_name = $parent_first_name;
		}

		/**
		 * Setter function for parent_last_name
		 *
		 * @param $parent_last_name
		 */
		public function set_parent_last_name( $parent_last_name ) {
			$this->parent_last_name = $parent_last_name;
		}

		/**
		 * Setter function for parent_email
		 *
		 * @param $parent_email
		 */
		public function set_parent_email( $parent_email ) {
			$this->parent_email = $parent_email;
		}

		/**
		 * Setter function for event_id
		 *
		 * @param $event_id
		 */
		public function set_event_id( $event_id ) {
			$this->event_id = $event_id;
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
		 * Setter function for email_priority
		 *
		 * @param $email_priority
		 */
		public function set_email_priority( $email_priority ) {
			$this->email_priority = $email_priority;
		}

		/**
		 * Setter function for creation_time
		 *
		 * @param $creation_time
		 */
		public function set_creation_time( $creation_time ) {
			$this->creation_time = $creation_time;
		}

		/**
		 * Setter function for sent_time
		 *
		 * @param $sent_time
		 */
		public function set_sent_time( $sent_time ) {
			$this->sent_time = $sent_time;
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
		 * Getter function for student_first_name
		 * @return string
		 */
		public function get_student_first_name() {
			return $this->student_first_name;
		}

		/**
		 * Getter function for student_last_name
		 * @return string
		 */
		public function get_student_last_name() {
			return $this->student_last_name;
		}

		/**
		 * Getter function for student_email
		 * @return string
		 */
		public function get_student_email() {
			return $this->student_email;
		}

		/**
		 * Getter function for parent_id
		 * @return int
		 */
		public function get_parent_id() {
			return $this->parent_id;
		}

		/**
		 * Getter function for parent_first_name
		 * @return string
		 */
		public function get_parent_first_name() {
			return $this->parent_first_name;
		}

		/**
		 * Getter function for parent_last_name
		 * @return string
		 */
		public function get_parent_last_name() {
			return $this->parent_last_name;
		}

		/**
		 * Getter function for parent_email
		 * @return string
		 */
		public function get_parent_email() {
			return $this->parent_email;
		}

		/**
		 * Getter function for event_id
		 * @return int
		 */
		public function get_event_id() {
			return $this->event_id;
		}

		/**
		 * Getter function for trigger_type
		 * @return string
		 */
		public function get_trigger_type() {
			return $this->trigger_type;
		}

		/**
		 * Getter function for email_priority
		 * @return string
		 */
		public function get_email_priority() {
			return $this->email_priority;
		}

		/**
		 * Getter function for creation_time
		 * @return int
		 */
		public function get_creation_time() {
			return $this->creation_time;
		}

		/**
		 * Getter function for sent_time
		 * @return int
		 */
		public function get_sent_time() {
			return $this->sent_time;
		}

		/**
		 * Save the email triggers, insert a row in the custom table.
		 *
		 * @param array $setData
		 */
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
			$data['email_priority']     = $this->get_email_priority();
			$data['creation_time']      = $this->get_creation_time();
			$data['sent_time']          = empty( $this->get_sent_time() ) ? 0 : $this->get_sent_time();

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
				$table_name = $this->table_prefix . $this->table_name;
				$final_sql  = "INSERT INTO `$table_name` ($columns) VALUES ( $final_values)";

				$this->bit_conn->query( $final_sql );
				$message = "Inserted data for student id: $student_id";

				echo "<br>" . $message;

				if ( ! empty( $this->bit_conn->error ) ) {
					echo '<br>Error: ';
					print_r( $this->bit_conn->error );
				}
			}
		}

		/**
		 * Get the database connection
		 * @return mysqli
		 */
		public function get_connection() {
			$conn = new mysqli( "localhost", "root", "", "bitwise" );
			// Check connection
			if ( $conn->connect_errno ) {
				echo "Failed to connect to MySQL: " . $conn->connect_error;
				exit();
			}

			return $conn;
		}

		/**
		 * To setting up emails for different events
		 */
		public function setup_emails() {
			$event_types = array( 'course_completed', 'inactive_student' );
			foreach ( $event_types as $event_type ) {
				$method = 'setup_emails_' . $event_type;
				call_user_func( array( $this, $method ), $event_type );
			}
		}

		/**
		 * Setting up an email trigger for course completed
		 *
		 * @param $trigger_type
		 */
		public function setup_emails_course_completed( $trigger_type ) {
			$beginOfDay = strtotime( "today" );
			$endOfDay   = strtotime( "tomorrow", $beginOfDay ) - 1;

			$user_sql     = "SELECT `user_id` as student_id, `meta_key` as course_key, `meta_value` as completed_time from " . $this->table_prefix . 'usermeta' . " WHERE `meta_key` LIKE '%course_completed_%' AND `meta_value` BETWEEN  '$beginOfDay' AND '$endOfDay'";
			$user_results = $this->bit_conn->query( $user_sql );
			if ( $user_results->num_rows > 0 ) {
				$mail_priority = 0;
				while ( $row = $user_results->fetch_array() ) {
					$student_id     = isset( $row['student_id'] ) ? $row['student_id'] : 0;
					$course_id      = str_replace( 'course_completed_', '', $row['course_key'] );
					$completed_time = $row['completed_time'];
					if ( $student_id > 0 ) {
						$this->setup_email_triggers( $student_id, $course_id, $trigger_type, $mail_priority, $completed_time );
					}
				}
			}
		}

		/**
		 * Setting up an email for student inactivity for last 15 days
		 *
		 * @param $trigger_type
		 */
		public function setup_emails_inactive_student( $trigger_type ) {
			$two_weeks_age = strtotime( "-14 days" );
			$user_sql      = "SELECT `user_id` as student_id, `meta_value` as login_time from " . $this->table_prefix . 'usermeta' . " WHERE `meta_key` = 'learndash-last-login' AND `meta_value` < '$two_weeks_age' AND `user_id` IN (SELECT `user_id` from " . $this->table_prefix . 'usermeta' . " WHERE `meta_key` = 'bit_capabilities' AND (`meta_value` LIKE '%subscriber%' OR `meta_value` LIKE '%student%'))";
			$user_results  = $this->bit_conn->query( $user_sql );
			if ( $user_results->num_rows > 0 ) {
				$mail_priority = 1;
				while ( $row = $user_results->fetch_array() ) {
					$student_id     = isset( $row['student_id'] ) ? $row['student_id'] : 0;
					$completed_time = $row['login_time'];
					if ( $student_id > 0 ) {
						$this->setup_email_triggers( $student_id, 0, $trigger_type, $mail_priority, $completed_time );
					}
				}
			}
		}

		/**
		 * Setting up different column values for email triggers
		 *
		 * @param $student_id
		 * @param $event_id
		 * @param $trigger
		 * @param $priority
		 * @param $creation_time
		 */
		public function setup_email_triggers( $student_id, $event_id, $trigger, $priority, $creation_time ) {
			$student_details = $this->get_student_details( $student_id );
			$parent_details  = $this->get_parent_details( $student_id );

			$this->set_student_id( $student_id );
			$this->set_student_first_name( $student_details['first_name'] );
			$this->set_student_last_name( $student_details['last_name'] );
			$this->set_student_email( $student_details['student_email'] );
			$this->set_parent_id( $parent_details['parent_id'] );
			$this->set_parent_first_name( $parent_details['parent_first_name'] );
			$this->set_parent_last_name( $parent_details['parent_last_name'] );
			$this->set_parent_email( $parent_details['parent_email'] );
			$this->set_event_id( $event_id );
			$this->set_trigger_type( $trigger );
			$this->set_email_priority( $priority );
			$this->set_creation_time( $creation_time );
			$this->set_sent_time( 0 );
			$this->save();
		}

		/**
		 * Getting student details like first name, last name and emails.
		 *
		 * @param $student_id
		 *
		 * @return array
		 */
		public function get_student_details( $student_id ) {
			$result          = array(
				'first_name'    => '',
				'last_name'     => '',
				'student_email' => '',
			);
			$student_sql     = "SELECT `meta_key`, `meta_value` from " . $this->table_prefix . 'usermeta' . " WHERE `meta_key` IN ('first_name','last_name') AND `user_id`=$student_id";
			$student_results = $this->bit_conn->query( $student_sql );
			if ( $student_results->num_rows > 0 ) {
				while ( $student_row = $student_results->fetch_assoc() ) {
					$result['first_name'] = ( 'first_name' === $student_row['meta_key'] ) ? $student_row['meta_value'] : $result['first_name'];
					$result['last_name']  = ( 'last_name' === $student_row['meta_key'] ) ? $student_row['meta_value'] : $result['last_name'];
				}

				$student_email_sql    = "SELECT `user_email` as student_email from " . $this->table_prefix . 'users' . " WHERE `ID`=$student_id";
				$student_email_result = $this->bit_conn->query( $student_email_sql );
				if ( $student_email_result->num_rows > 0 ) {
					while ( $email_row = $student_email_result->fetch_assoc() ) {
						$result['student_email'] = isset( $email_row['student_email'] ) ? $email_row['student_email'] : $result['student_email'];
					}
				}
			}

			return $result;
		}

		/**
		 * Getting parent details like parent id, first name, last name and emails.
		 * @param $student_id
		 *
		 * @return array
		 */
		public function get_parent_details( $student_id ) {
			$result          = array(
				'parent_first_name' => '',
				'parent_last_name'  => '',
				'parent_email'      => '',
				'parent_id'         => 0,
			);
			$group_id_sql    = "SELECT `meta_value` as group_id from " . $this->table_prefix . 'usermeta' . " WHERE `meta_key` LIKE '%learndash_group_users_%' AND `user_id`=$student_id";
			$group_id_result = $this->bit_conn->query( $group_id_sql );
			$group_id        = $parent_id = 0;
			if ( $group_id_result->num_rows > 0 ) {
				while ( $group_row = $group_id_result->fetch_assoc() ) {
					$group_id = isset( $group_row['group_id'] ) ? $group_row['group_id'] : $group_id;
				}
				if ( $group_id > 0 ) {
					$parent_id_sql    = "SELECT `user_id` as parent_id from " . $this->table_prefix . 'usermeta' . " WHERE `meta_key` LIKE '%learndash_group_leaders_$group_id%'";
					$parent_id_result = $this->bit_conn->query( $parent_id_sql );
					if ( $parent_id_result->num_rows > 0 ) {
						while ( $parent_row = $parent_id_result->fetch_assoc() ) {
							$parent_id = isset( $parent_row['parent_id'] ) ? $parent_row['parent_id'] : $parent_id;
						}

						if ( $parent_id > 0 ) {
							$parent_sql     = "SELECT `meta_key`, `meta_value` from " . $this->table_prefix . 'usermeta' . " WHERE `meta_key` IN ('first_name','last_name') AND `user_id`=$parent_id";
							$parent_results = $this->bit_conn->query( $parent_sql );
							if ( $parent_results->num_rows > 0 ) {
								while ( $parent_row = $parent_results->fetch_assoc() ) {
									$result['parent_first_name'] = ( 'first_name' === $parent_row['meta_key'] ) ? $parent_row['meta_value'] : $result['parent_first_name'];
									$result['parent_last_name']  = ( 'last_name' === $parent_row['meta_key'] ) ? $parent_row['meta_value'] : $result['parent_last_name'];
								}
							}

							$parent_email_sql    = "SELECT `user_email` as parent_email from " . $this->table_prefix . 'users' . " WHERE `ID`=$parent_id";
							$parent_email_result = $this->bit_conn->query( $parent_email_sql );
							if ( $parent_email_result->num_rows > 0 ) {
								while ( $email_row = $parent_email_result->fetch_assoc() ) {
									$result['parent_email'] = isset( $email_row['parent_email'] ) ? $email_row['parent_email'] : $result['parent_email'];
								}
							}
							$result['parent_id'] = $parent_id;
						}
					}
				}
			}

			return $result;
		}

		/**
		 * Creating email trigger table
		 */
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
				`email_priority` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
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
