using System;
using System.Collections.Generic;
using System.Data.SqlClient;

namespace SoapBooks
{ 

public class BookService : IBookService
{
    private string connectionString = System.Configuration.ConfigurationManager.ConnectionStrings["BooksDBConnectionString"].ToString();

    public void AddBook(Book book)
    {
        using (SqlConnection conn = new SqlConnection(connectionString))
        {
            string query = "INSERT INTO Books (Title, Author, Price) VALUES (@Title, @Author, @Price)";
            SqlCommand cmd = new SqlCommand(query, conn);
            cmd.Parameters.AddWithValue("@Title", book.Title);
            cmd.Parameters.AddWithValue("@Author", book.Author);
            cmd.Parameters.AddWithValue("@Price", book.Price);

            conn.Open();
            cmd.ExecuteNonQuery();
        }
    }

    public Book GetBook(int id)
    {
        using (SqlConnection conn = new SqlConnection(connectionString))
        {
            string query = "SELECT * FROM Books WHERE Id = @Id";
            SqlCommand cmd = new SqlCommand(query, conn);
            cmd.Parameters.AddWithValue("@Id", id);

            conn.Open();
            SqlDataReader reader = cmd.ExecuteReader();
            if (reader.Read())
            {
                return new Book
                {
                    Id = (int)reader["Id"],
                    Title = reader["Title"].ToString(),
                    Author = reader["Author"].ToString(),
                    Price = (decimal)reader["Price"]
                };
            }
            else
            {
                return null;
            }
        }
    }

    public List<Book> GetAllBooks()
    {
        List<Book> books = new List<Book>();
        using (SqlConnection conn = new SqlConnection(connectionString))
        {
            string query = "SELECT * FROM Books";
            SqlCommand cmd = new SqlCommand(query, conn);

            conn.Open();
            SqlDataReader reader = cmd.ExecuteReader();
            while (reader.Read())
            {
                books.Add(new Book
                {
                    Id = (int)reader["Id"],
                    Title = reader["Title"].ToString(),
                    Author = reader["Author"].ToString(),
                    Price = (decimal)reader["Price"]
                });
            }
        }
        return books;
    }

    public void UpdateBook(Book book)
    {
        using (SqlConnection conn = new SqlConnection(connectionString))
        {
            string query = "UPDATE Books SET Title = @Title, Author = @Author, Price = @Price WHERE Id = @Id";
            SqlCommand cmd = new SqlCommand(query, conn);
            cmd.Parameters.AddWithValue("@Id", book.Id);
            cmd.Parameters.AddWithValue("@Title", book.Title);
            cmd.Parameters.AddWithValue("@Author", book.Author);
            cmd.Parameters.AddWithValue("@Price", book.Price);

            conn.Open();
            cmd.ExecuteNonQuery();
        }
    }

    public void DeleteBook(int id)
    {
        using (SqlConnection conn = new SqlConnection(connectionString))
        {
            string query = "DELETE FROM Books WHERE Id = @Id";
            SqlCommand cmd = new SqlCommand(query, conn);
            cmd.Parameters.AddWithValue("@Id", id);

            conn.Open();
            cmd.ExecuteNonQuery();
        }
    }
}

}