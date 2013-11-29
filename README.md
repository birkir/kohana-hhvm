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


Immediently ran into preg_replace /e modifier fatal so we replace it with preg_replace_callback:

	preg_replace($regex, 'str_repeat($replacement, UTF8::strlen(\'$1\'))', $str);

	... with ...

	preg_replace_callback($regex, function ($m) { return str_repeat($replacement, UTF8::strlen($m[1])); }, $str);

