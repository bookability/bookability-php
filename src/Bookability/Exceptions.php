<?php

class Bookability_Error extends Exception {}
class Bookability_HttpError extends Bookability_Error {}


/**
 * The parameters passed to the API call are invalid or not provided when required
 */
class Mailchimp_ValidationError extends Bookability_Error {}