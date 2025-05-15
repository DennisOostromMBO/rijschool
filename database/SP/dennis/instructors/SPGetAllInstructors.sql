CREATE PROCEDURE SPGetAllInstructors()
BEGIN
    SELECT 
        users.first_name,
        users.middle_name,
        users.last_name,
        users.birth_date,
        contacts.full_address,
        contacts.email,
        instructors.number
    FROM instructors
    INNER JOIN users ON instructors.user_id = users.id
    INNER JOIN contacts ON contacts.user_id = users.id
    WHERE instructors.is_active = 1 AND contacts.is_active = 1;
END;