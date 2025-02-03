namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class CustomException extends HttpException
{
    public function __construct(string $message = "Custom Error", int $statusCode = 400)
    {
        parent::__construct($statusCode, $message);
    }
}
