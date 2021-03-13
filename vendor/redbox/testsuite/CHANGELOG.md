## 2.0

- The average() method on the TestSuite class now returns the average score of all tests.
- Attach() and Detach() now return $this on TestSuite so you can chain the function with other TestSuite functions.
- Added a method of entering the answer of the user to the score increment.
- You can now opt not to reset tests scores every time the suite runs.
- Added the possibility to add a motivation with the score increment.
- Tests can now be attached to a TestSuite by only passing a php class name. Test suite will automatically initialize the test class.
- Added a storage container to the TestSuite class that can be used to forward information to the tests.
- Added tests for the new storage container class.
- Added a new Container example in the example's directory.
- Added comments to all tests spec or unit tests.
- Updated a typo in license part of README.md.

## 1.0

This is the first stable release of redbox-testsuite.