Template Documents(___DEVELOP___)
---
Template File Using `tpl` suffix.

Syntax
---

#### __Print Variable__
__Example__:
```
{ @variable }
```

#### __Print Array Element__
__Example__:
```
{ @array.element }
```
> NOTE: Can only print up to two-dimensional array
> ```
> { @array.element1.element2 } # OK
> { @@array.element1.element2.element3... } # Failure
> ```
> DEVELOP VERSION.

#### __Function Callback__
__Example__:
```
{ @timestamp $ (class.method(args, ...)) }
```
__Available Method__:
* `time.format(format)`: Print a string formatted according to the given format 
string using the given integer timestamp(`@timestamp`).

#### __Foreach__
__Example__:
```
{ foreach @array - @element }
    # do something...
{ endforeach }

# or

{ foreach @array - @key + @val }
    # do something...
{ endforeach }
```

#### __Special loop__
__Example__:
```
{ loop }
    # do something...
{ endloop }
```
> NOTE: This syntax is shorthand,If the traversal element is an array of 
variables in this scope will give priority to judge the elements of this array
> ```
> { loop }           => { foreach @data - @__index + @__value }
>     { @element }   =>     { @__value.element }
> { endloop }        => { endforeach }
> ```
> DEVELOP VERSION.

#### __If__
__Example__:
```
{ if @variable == 1 }
    { @variable }
{ else }
    { @other }
{ endif }
```
