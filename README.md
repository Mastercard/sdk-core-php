# Introduction

This is the SDK Core Api for all the SDK used in MasterCard. 
It provides some Core functionality for all our SDKs.

It provide:
	- Exception handling.
	- Security (OAUTH).
	- Crypt utilities.
	- Message pump
	- Smart map. (for inline request creation using fluent style api)

# Setup
This is composer project.
For simplicity I've added to the project under the bin an instance of composer.

~~~bash
	chmod +x *.sh
	./composer.sh install
	./run-test.sh
~~~

## Ignore tests

~~~bash
	./composer.sh exec -- phpunit --debug --filter test_utf_8
~~~

## Run a single test

~~~bash
	./composer.sh exec -- phpunit --filter test500_invalidrequest_json_native
~~~
