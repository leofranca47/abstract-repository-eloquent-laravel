# ABSTRACT REPOSITORY ELOQUENT LARAVEL


Essa é uma classe php onde tem métodos que podem ser chamados igual no "Eloquent". Serve para criar repositórios e facilitar os testes unitários sem perder o poder do "Eloquent"

This is a php class where it has methods that can be called equal in Eloquent. It serves to create responses and facilitate unit tests without losing the power of the Eloquent 

## USE


Para utilizar a classe é necessário criar uma classe concreta e estender da nossa classe.
Na classe concreta é necessário criar o método que está implementado na classe abstrata, segue o exemplo abaixo:

To use the class it is necessary to create a concrete class and extend from our class.
In the concrete class it is necessary to create the method that is implemented in the abstract class, follows the example below:

````angular2html
protected function resolveModel(): Model
{
    return app(Model::class);
}
````
