# Commission task

## Running tests:

```
$ composer run test
```

## Adding new currency

`setUp` function in `CoreTest.php` :
```
$this->core->addCurrency(new Currency('<NAME>', <PRECISION>));
```

## Changing input file
Just change input.csv in `tests/core`. 

**Norice: you must add expected result as last column**

## If running using docker
You can build docker image and then run commands like:

```
$ docker run --rm -it -v $PWD:/var/www <IMAGE_NAME>:<IMAGE_TAG> <COMMAND>
```