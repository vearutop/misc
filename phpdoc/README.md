# Heal your code with PHPDoc

Developing large-scale application is a challenge. 
With system complexity growth, further developing can become as difficult as searching needle in haystack. 
When understanding context and finding a proper place in code to integrate your feature will be much harder than implementation itself.
Having reflexive and self-describing code helps a lot to keep project healthy and developers happy.

Many troubles come from indeterminacy of data structures and call traces. 
Due to loosely typed nature of PHP sometimes it hard to find what kind of information is stored in variable or which methods are available.
Modern IDEs such as PHPStorm do a great job of performing statical code analysis and aiding developer with code auto completion 
and error detecting. 

Developer can help IDE to help him.

## Benefits of reflexive code, find usages, refactoring
### Avoid literals and reusable variables
### Word on immutable objects
### Symbolizing literals with constants

## Helpful `phpdoc` practices
### Using `@return $this`, `@return static` to hint abstract class descendants
### Hinting multiple types with `|`
### Hinting traversables with `Item[]`
### Using `@method` to describe magic methods
### Using `@see`, `@uses` to make references
### Using `@property`, `@property-read`, `@property-write` to hint magic properties
### `instanceof` as type hinter
### Hinting variadic arguments with `@param`
### Overriding local variable or property with `@var`
### Calling static methods on string variable with `@var SomeClass`
### Hinting `new $className` with `@var CommonAncestor` 
### Defining `array` structure with stub classes
### Not possible to hint array key or specific array item, do not use arrays
### Type-hinting argument with `null` default value

## General purpose tags
### `@internal`
### `@deprecated`
### `@todo`

## See also
* http://www.phpdoc.org/docs/latest/references/phpdoc/tags/index.html
* http://stackoverflow.com/questions/tagged/phpdoc
* https://blog.jetbrains.com/phpstorm/2014/04/phpstorm-8-markdown-support-in-phpdoc-blocks/
* http://usejsdoc.org/ :)


