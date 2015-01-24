<?php


	/** The name of the database for WordPress */
	define('DB_NAME', 'database_name_here');

	/** MySQL database username */
	define('DB_USER', 'username_here');

	/** MySQL database password */
	define('DB_PASSWORD', 'password_here');

	/** MySQL hostname */
	define('DB_HOST', 'localhost');

	/** Database Charset to use in creating database tables. */
	define('DB_CHARSET', 'utf8');

	/** The Database Collate type. Don't change this if in doubt. */
	define('DB_COLLATE', '');

	/**#@+
	 * Authentication Unique Keys and Salts.
	 *
	 * Change these to different unique phrases!
	 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
	 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
	 *
	 * @since 2.6.0
	 */
	define('AUTH_KEY',         '{0P}Aq5i+G^KvjJpB@rCtWci-,N-+pt RD|(?8VuV#7txmf+-wx8$uIU?1-JTQC?');
	define('SECURE_AUTH_KEY',  'iVFYlhHbhF]kCO3ulE)&;7Kj*DZ6t=kw/d|L~7%vFtv;N#Y+vN`culsMtW[44BH,');
	define('LOGGED_IN_KEY',    '1*FzsO-sH)So+`b1;@_<P9[{+k_:TvJ^xThCjo0 sZ-p{^Rz92|-rHV$}lKJQyG<');
	define('NONCE_KEY',        'N%pk_^VoWlZ`:%=k%?O2,g6)}0hK2M=~E-7-We{]`,v~l]2RsaAjKL_3XQ~*L`>A');
	define('AUTH_SALT',        'w~Tq)_lCC5q$4Dz GzznVW^?u)]RL}!-pZ+mv,.O?:=gI20b$uz<,nmB%_B+Q$qY');
	define('SECURE_AUTH_SALT', 'Jm6u#A:vl=?vh}fQ+V7d4t-Q(:2J?=|=[+<pbkVv8b$+|YC#!(weU+g *-BAm=uD');
	define('LOGGED_IN_SALT',   '?/_qIgzMc g%;Yf~%Gu13kP_(1A2@sej#L^gUgfrN^X%|u,ndchG`+gTaecQ}+;y');
	define('NONCE_SALT',       't4m;m2#T>.VN&dP6c%}i7=PUD;Qw)|De)y|uS<XJW)a-=&uDI1D{t+VC HF3Ntbb');

	/**
	 * For developers: WordPress debugging mode.
	 *
	 * Change this to true to enable the display of notices during development.
	 * It is strongly recommended that plugin and theme developers use WP_DEBUG
	 * in their development environments.
	 */
	define('WP_DEBUG', true);