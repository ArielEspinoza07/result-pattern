<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern\Enums;

enum HttpResponseStatusCode: int
{
// 1xx Informational
    case Continue = 100;
    case SwitchingProtocols = 101;
    case Processing = 102;
    case EarlyHints = 103;

    // 2xx Success
    case OK = 200;
    case Created = 201;
    case Accepted = 202;
    case NonAuthoritativeInformation = 203;
    case NoContent = 204;
    case ResetContent = 205;
    case PartialContent = 206;
    case MultiStatus = 207;
    case AlreadyReported = 208;
    case IMUsed = 226;

    // 3xx Redirection
    case MultipleChoices = 300;
    case MovedPermanently = 301;
    case Found = 302;
    case SeeOther = 303;
    case NotModified = 304;
    case UseProxy = 305;
    case TemporaryRedirect = 307;
    case PermanentRedirect = 308;

    // 4xx Client Errors
    case BadRequest = 400;
    case Unauthorized = 401;
    case PaymentRequired = 402;
    case Forbidden = 403;
    case NotFound = 404;
    case MethodNotAllowed = 405;
    case NotAcceptable = 406;
    case ProxyAuthenticationRequired = 407;
    case RequestTimeout = 408;
    case Conflict = 409;
    case Gone = 410;
    case LengthRequired = 411;
    case PreconditionFailed = 412;
    case PayloadTooLarge = 413;
    case UriTooLong = 414;
    case UnsupportedMediaType = 415;
    case RangeNotSatisfiable = 416;
    case ExpectationFailed = 417;
    case ImATeapot = 418;
    case MisdirectedRequest = 421;
    case UnprocessableEntity = 422;
    case Locked = 423;
    case FailedDependency = 424;
    case TooEarly = 425;
    case UpgradeRequired = 426;
    case PreconditionRequired = 428;
    case TooManyRequests = 429;
    case RequestHeaderFieldsTooLarge = 431;
    case UnavailableForLegalReasons = 451;

    // 5xx Server Errors
    case InternalServerError = 500;
    case NotImplemented = 501;
    case BadGateway = 502;
    case ServiceUnavailable = 503;
    case GatewayTimeout = 504;
    case HttpVersionNotSupported = 505;
    case VariantAlsoNegotiates = 506;
    case InsufficientStorage = 507;
    case LoopDetected = 508;
    case NotExtended = 510;
    case NetworkAuthenticationRequired = 511;

    /**
     * Get the human-readable message for this error
     */
    public function message(): string
    {
        return match($this) {
            // 1xx Informational
            self::Continue => 'Continue',
            self::SwitchingProtocols => 'Switching Protocols',
            self::Processing => 'Processing',
            self::EarlyHints => 'Early Hints',

            // 2xx Success
            self::OK => 'OK',
            self::Created => 'Created',
            self::Accepted => 'Accepted',
            self::NonAuthoritativeInformation => 'Non-Authoritative Information',
            self::NoContent => 'No Content',
            self::ResetContent => 'Reset Content',
            self::PartialContent => 'Partial Content',
            self::MultiStatus => 'Multi-Status',
            self::AlreadyReported => 'Already Reported',
            self::IMUsed => 'IM Used',

            // 3xx Redirection
            self::MultipleChoices => 'Multiple Choices',
            self::MovedPermanently => 'Moved Permanently',
            self::Found => 'Found',
            self::SeeOther => 'See Other',
            self::NotModified => 'Not Modified',
            self::UseProxy => 'Use Proxy',
            self::TemporaryRedirect => 'Temporary Redirect',
            self::PermanentRedirect => 'Permanent Redirect',

            // 4xx Client Errors
            self::BadRequest => 'Bad Request',
            self::Unauthorized => 'Unauthorized',
            self::PaymentRequired => 'Payment Required',
            self::Forbidden => 'Forbidden',
            self::NotFound => 'Not Found',
            self::MethodNotAllowed => 'Method Not Allowed',
            self::NotAcceptable => 'Not Acceptable',
            self::ProxyAuthenticationRequired => 'Proxy Authentication Required',
            self::RequestTimeout => 'Request Timeout',
            self::Conflict => 'Conflict',
            self::Gone => 'Gone',
            self::LengthRequired => 'Length Required',
            self::PreconditionFailed => 'Precondition Failed',
            self::PayloadTooLarge => 'Payload Too Large',
            self::UriTooLong => 'URI Too Long',
            self::UnsupportedMediaType => 'Unsupported Media Type',
            self::RangeNotSatisfiable => 'Range Not Satisfiable',
            self::ExpectationFailed => 'Expectation Failed',
            self::ImATeapot => 'I\'m a Teapot',
            self::MisdirectedRequest => 'Misdirected Request',
            self::UnprocessableEntity => 'Unprocessable Entity',
            self::Locked => 'Locked',
            self::FailedDependency => 'Failed Dependency',
            self::TooEarly => 'Too Early',
            self::UpgradeRequired => 'Upgrade Required',
            self::PreconditionRequired => 'Precondition Required',
            self::TooManyRequests => 'Too Many Requests',
            self::RequestHeaderFieldsTooLarge => 'Request Header Fields Too Large',
            self::UnavailableForLegalReasons => 'Unavailable For Legal Reasons',

            // 5xx Server Errors
            self::InternalServerError => 'Internal Server Error',
            self::NotImplemented => 'Not Implemented',
            self::BadGateway => 'Bad Gateway',
            self::ServiceUnavailable => 'Service Unavailable',
            self::GatewayTimeout => 'Gateway Timeout',
            self::HttpVersionNotSupported => 'HTTP Version Not Supported',
            self::VariantAlsoNegotiates => 'Variant Also Negotiates',
            self::InsufficientStorage => 'Insufficient Storage',
            self::LoopDetected => 'Loop Detected',
            self::NotExtended => 'Not Extended',
            self::NetworkAuthenticationRequired => 'Network Authentication Required'
        };
    }

    /**
     * Get a more detailed description of this error
     */
    public function description(): string
    {
        return match($this) {
            self::BadRequest => 'The server cannot process the request due to a client error.',
            self::Unauthorized => 'Authentication is required and has failed or has not been provided.',
            self::PaymentRequired => 'Payment is required before the resource can be accessed.',
            self::Forbidden => 'The server understood the request but refuses to authorize it.',
            self::NotFound => 'The requested resource could not be found.',
            self::MethodNotAllowed => 'The request method is not supported for the requested resource.',
            self::NotAcceptable => 'The requested resource is capable of generating only content not acceptable according to the Accept headers.',
            self::ProxyAuthenticationRequired => 'The client must first authenticate itself with the proxy.',
            self::RequestTimeout => 'The client did not produce a request within the time that the server was prepared to wait.',
            self::Conflict => 'The request could not be completed due to a conflict with the current state of the resource.',
            self::Gone => 'The requested resource is no longer available and will not be available again.',
            self::LengthRequired => 'The server requires a Content-Length header to be specified.',
            self::PreconditionFailed => 'The server does not meet one of the preconditions specified by the client.',
            self::PayloadTooLarge => 'The request payload is larger than the server is willing or able to process.',
            self::UriTooLong => 'The URI provided was too long for the server to process.',
            self::UnsupportedMediaType => 'The server does not support the media type transmitted in the request.',
            self::RangeNotSatisfiable => 'The client has asked for a portion of the file but the server cannot supply that portion.',
            self::ExpectationFailed => 'The server cannot meet the requirements of the Expect request-header field.',
            self::ImATeapot => 'Any attempt to brew coffee with a teapot should result in this error.',
            self::MisdirectedRequest => 'The request was directed at a server that is not able to produce a response.',
            self::UnprocessableEntity => 'The request was well-formed but was unable to be followed due to semantic errors.',
            self::Locked => 'The resource that is being accessed is locked.',
            self::FailedDependency => 'The request failed due to failure of a previous request.',
            self::TooEarly => 'The server is unwilling to risk processing a request that might be replayed.',
            self::UpgradeRequired => 'The client should switch to a different protocol.',
            self::PreconditionRequired => 'The origin server requires the request to be conditional.',
            self::TooManyRequests => 'The user has sent too many requests in a given amount of time.',
            self::RequestHeaderFieldsTooLarge => 'The server is unwilling to process the request because its header fields are too large.',
            self::UnavailableForLegalReasons => 'The requested resource is unavailable for legal reasons.',
            self::InternalServerError => 'The server encountered an unexpected condition that prevented it from fulfilling the request.',
            self::NotImplemented => 'The server does not support the functionality required to fulfill the request.',
            self::BadGateway => 'The server received an invalid response from the upstream server.',
            self::ServiceUnavailable => 'The server is currently unable to handle the request due to temporary overloading or maintenance.',
            self::GatewayTimeout => 'The server did not receive a timely response from the upstream server.',
            self::HttpVersionNotSupported => 'The server does not support the HTTP protocol version used in the request.',
            self::VariantAlsoNegotiates => 'The server has an internal configuration error.',
            self::InsufficientStorage => 'The server is unable to store the representation needed to complete the request.',
            self::LoopDetected => 'The server detected an infinite loop while processing the request.',
            self::NotExtended => 'Further extensions to the request are required for the server to fulfill it.',
            self::NetworkAuthenticationRequired => 'The client needs to authenticate to gain network access.'
        };
    }
}
