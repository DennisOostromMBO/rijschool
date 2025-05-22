CREATE PROCEDURE SPGetAllStudents()
BEGIN
    SELECT 
        user.full_name,
        user.birth_date,
        stud.relation_number,
        cont.full_address,
        cont.mobile,
        cont.email,
        (SELECT CONCAT(inst.first_name, ' ', COALESCE(inst.middle_name, ''), ' ', inst.last_name) 
         FROM users inst 
         WHERE inst.id = IF(stud.id % 2 = 0, 3, 4)) as instructor_name
    FROM students stud
    INNER JOIN users user ON stud.user_id = user.id
    INNER JOIN contacts cont ON cont.user_id = user.id
    ORDER BY user.full_name;
END;