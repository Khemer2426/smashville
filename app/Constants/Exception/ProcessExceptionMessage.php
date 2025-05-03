<?php

namespace App\Constants\Exception;

class ProcessExceptionMessage
{
    public const INVALID_USER_CREDENTIALS = "Invalid credentials.";
    public const USER_DOES_NOT_EXIST = "User does not exist.";
    public const USER_ALREADY_EXISTS = "User already exists.";
    public const CODE_EXPIRY_MUST_BE_A_NUMBER = 'Code expiry must be a number';
    public const PASSWORD_MISMATCH = "Password mismatch.";
    public const CURRENT_PASSWORD_INVALID = "Current password is invalid.";
    public const NOTIFICATION_TRIGGER_DOES_NOT_EXIST = "Notification trigger does not exist.";
    public const EMAIL_TEMPLATE_DOES_NOT_EXIST = "Email template does not exist.";
    public const EMAIL_NOTIFICATION_DOES_NOT_EXIST = "Email notification does not exist.";
    public const ERROR_IN_SENDING_EMAIL = "Error in sending email.";
    public const FILE_DOES_NOT_EXIST = "File does not exist.";
    public const FILE_TYPE_DOES_NOT_EXIST = "File type does not exist.";
    public const ERROR_GET_DATA_KEYVAULT = "Error getting data from keyvault.";
    public const USER_ALREADY_ACTIVE = 'User is already activated.';
    public const CODE_IS_INVALID = 'The code is invalid.';
    public const USER_IS_NOT_ACTIVE = 'The user is not active.';
    public const ROLE_DOES_NOT_EXIST = "Role does not exist.";
    public const ACTION_NOT_ALLOWED = "Action is not allowed.";
    public const EMAIL_NOT_VERIFIED = "The email is not verified.";
    public const INVALID_USER = "Invalid user";
    public const EMAIL_IS_NOT_MATCH = "The email is not match with company domain.";
    public const ROLE_IS_INVALID = "The role is invalid.";
    public const USER_IS_NOT_MULTISCHOOL_ROLE = "The user is not multischool role.";
    public const SCHOOL_IS_ALREADY_ASSIGNED_TO_USER = "The school is already assigned to a user.";
    public const INVALID_SECTOR = "The sector is not valid.";
    public const SCHOOL_DOES_NOT_EXIST = "The school does not exist.";
    public const LOCALITY_DOES_NOT_EXIST = "The locality does not exist.";
    public const LEAVE_TERMINATION_DOES_NOT_EXIST = "The leave/termination does not exist.";
    public const LEAVE_TERMINATION_TYPE_DOES_NOT_EXIST = "The leave/termination type does not exist.";
    public const PROVISION_DOES_NOT_EXIST = "The provision does not exist.";
    public const SCHOOL_YEAR_DOES_NOT_EXIST = "The school year does not exist.";
    public const CRITERIA_DOES_NOT_EXIST = 'The criteria does not exist.';
    public const YEAR_DOES_NOT_EXIST = 'The year does not exist.';
    public const STUDENT_DOES_NOT_EXIST = 'The student does not exist.';
    public const NO_DEFAULT_SCHOOL_YEAR = "No default school year.";
    public const NO_DUPLICATE_HAS_BEEN_FOUND = "No duplicate has been found.";
    public const CLASS_DOES_NOT_EXIST = "The class does not exist.";
    public const STUDENT_CLASS_DOES_NOT_EXIST = "The student class does not exist.";
    public const POPULATION_DOES_NOT_EXIST = "The population does not exist.";
    public const LSE_DOES_NOT_EXIST = "The LSE does not exist.";
    public const LSE_IS_ALREADY_EXIST_IN_SCHOOL = "The LSE with that ID is already exists in this school.";
    public const LEAVE_DOES_NOT_EXIST = "Leave does not exist.";
    public const GRADE_DOES_NOT_EXIST = "The grade does not exist.";
    public const SUPPLY_LSE_APPROVAL_REQUIRES_END_DATE = "Supply LSE approvals requires end date.";
    public const FOLIO_NUMBER_DOES_NOT_EXIST = "The folio number does not exists.";
    public const FOLIO_NUMBER_IS_ALREADY_EXIST = "The folio number is already exists.";
}

