CREATE PROCEDURE SPGetAllStudents()
BEGIN
    SELECT 
        u.full_name,
        u.birth_date,
        s.relation_number,
        c.full_address,
        c.mobile,
        c.email,
        (SELECT CONCAT(i.first_name, ' ', COALESCE(i.middle_name, ''), ' ', i.last_name) 
         FROM users i 
         WHERE i.id = IF(s.id % 2 = 0, 3, 4)) as instructor_name
    FROM students s
    INNER JOIN users u ON s.user_id = u.id
    INNER JOIN contacts c ON c.user_id = u.id
    ORDER BY u.full_name;
END;


