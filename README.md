PHP Version

	PHP 5.5.5-1+debphp.org~precise+1 (cli) (built: Oct 21 2013 07:57:06)


HipHop config

	Eval {
        JitASize = 134217728
        JitAStubsSize = 134217728
        JitGlobalDataSize = 67108864
	}


Run unit tests with php

	php vendor/bin/phpunit --bootstrap=modules/unittest/bootstrap.php modules/unittest/tests.php

	...

	Tests: 1170, Assertions: 2662, Errors: 4, Incomplete: 1, Skipped: 17.


Run unit tests with hhvm

	sudo hhvm -c config.hdf vendor/bin/phpunit --bootstrap=modules/unittest/bootstrap.php modules/unittest/tests.php

	...

	HipHop Fatal error: preg_replace is not going to be supported: Modifier /e must be used with the form f("<replacement string>") or f("<replacement string>"); in SYSPATH/classes/Kohana/Text.php on line 299


Immediently ran into preg_replace /e modifier fatal so we replace it with preg_replace_callback. Also fixed callback in utf8/ucwords.php.

Run the tests again and they run with seven failures.

	Tests: 1170, Assertions: 2676, Failures: 7, Errors: 3, Incomplete: 1, Skipped: 5

Errors

	1. Kohana_TextTest::test_censor with data set #0 ('A donkey is also an ***', 'A donkey is also an ass', array('ass'), '*', true)

		Undefined variable: replacement

	2. Kohana_TextTest::test_censor with data set #1 ('Cake### isn\'t nearly as good as kohana###', 'CakePHP isn\'t nearly as good as kohanaphp', array('php'), '#', true)

		Undefined variable: replacement

	3. Kohana_Request_ClientTest::test_follows_with_headers

		Undefined index: authorization

Fatals

	1. Kohana_CookieTest::test_set with data set #0 ('foo', 'bar', NULL, true)

		Failed asserting that false matches expected true.

	2. Kohana_CookieTest::test_set with data set #1 ('foo', 'bar', 10, true)

		Failed asserting that false matches expected true.

	3. Kohana_CookieTest::test_delete with data set #0 ('foo', true)

		Failed asserting that false matches expected true.

	4. Kohana_CoreTest::test_globals_removes_user_def_globals

		Failed asserting that two arrays are equal.

	5. Kohana_DateTest::test_formatted_time with data set #4 ('2011-04-01 01:23:45 Antarctica/South_Pole', '@1301574225', 'Y-m-d H:i:s e', 'Antarctica/South_Pole')

		Failed asserting that two strings are identical.

	6. Kohana_FeedTest::test_create with data set #0 ( ... )

		Failed asserting that false is true.

	7. Kohana_RouteTest::test_all_returns_all_defined_routes

		Failed asserting that Array() is identical to an object of class "ReflectionProperty".
