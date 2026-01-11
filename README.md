# Laravel Invoicing System

A comprehensive web application built with Laravel for managing invoices, products, and sections. This system provides an intuitive interface for creating, editing, and tracking invoices with advanced features like user permissions, file attachments, and Excel export functionality.

## Features

- **Invoice Management**: Create, edit, delete, and archive invoices with detailed information including due dates, amounts, VAT calculations, and payment status.
- **Product and Section Management**: Organize products into categories (sections) for better inventory control.
- **User and Permission Management**: Advanced role-based access control using Spatie Laravel Permission package.
- **File Attachments**: Upload and manage attachments for invoices (images, PDFs, etc.).
- **Payment Tracking**: Track invoice status (Paid, Unpaid, Partial) with payment date recording.
- **Excel Export**: Export invoice data to Excel spreadsheets using Maatwebsite Excel.
- **Responsive UI**: Modern, responsive interface built with Tailwind CSS and custom styling.
- **Multi-language Support**: Includes Arabic language support for user interface elements.

## Technologies Used

- **Laravel 11.9**: PHP web framework
- **PHP 8.2+**: Server-side scripting
- **MySQL**: Database management
- **Tailwind CSS**: Utility-first CSS framework
- **JavaScript**: Frontend interactions
- **Spatie Laravel Permission**: Role and permission management
- **Maatwebsite Excel**: Excel file generation
- **Laravel Collective HTML**: Form helpers

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/laravel-invoicing-system.git
   cd laravel-invoicing-system
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node.js dependencies:
   ```bash
   npm install
   ```

4. Copy the environment file and configure your database:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Run database migrations and seeders:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. Build assets:
   ```bash
   npm run build
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

- Access the application at `http://localhost:8000`
- Create sections and products first
- Add invoices with detailed information
- Track payment status and manage attachments
- Export data to Excel for reporting

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
