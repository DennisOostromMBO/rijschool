CREATE PROCEDURE SPGetAllInstructors()
BEGIN
    SELECT 
        user.first_name,
        user.middle_name,
        user.last_name,
        user.birth_date,
        cont.full_address,
        cont.email,
        inst.number
    FROM instructors inst
    INNER JOIN users user ON inst.user_id = user.id
    INNER JOIN contacts cont ON cont.user_id = user.id;
END;