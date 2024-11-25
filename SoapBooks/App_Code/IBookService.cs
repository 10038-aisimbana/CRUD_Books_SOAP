using System.Collections.Generic;
using System.ServiceModel;

namespace SoapBooks
{

    [ServiceContract]
public interface IBookService
{
    [OperationContract]
    void AddBook(Book book);

    [OperationContract]
    Book GetBook(int id);

    [OperationContract]
    List<Book> GetAllBooks();

    [OperationContract]
    void UpdateBook(Book book);

    [OperationContract]
    void DeleteBook(int id);
}
}

