# Introduction
This is the SDK Core Api for all the SDK used in MasterCard.
It provides some Core functionality for all our SDKs.
It provide:
- exception handling
- security (OAUTH)
- crypt utilities
- message pump
- smart map (for inline request creation using fluent style api)

# Setup
This is composer project.
For simplicity i've added to the project under the bin an instance of composer.

```
chmod +x composer.sh
chmod +x run-tests.sh
./composer install
./run-test
```

## Run a single test
`./composer exec -- phpunit --filter test500_invalidrequest_json_native`

