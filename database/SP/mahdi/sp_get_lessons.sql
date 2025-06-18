drop procedure if exists GetLessonOverview;

CREATE PROCEDURE GetLessonOverview()
BEGIN
    SELECT 
        CONCAT(su.first_name, ' ', COALESCE(su.middle_name, ''), ' ', su.last_name) AS student_name,
        CONCAT(iu.first_name, ' ', COALESCE(iu.middle_name, ''), ' ', iu.last_name) AS instructor_name,
        c.license_plate AS car_license_plate,
        l.start_date AS lesson_date,
        l.start_time AS lesson_start_time,
        l.end_date AS lesson_end_date,
        l.end_time AS lesson_end_time,
        l.lesson_status AS lesson_status,
        l.goal AS lesson_goal
    FROM lessons l
    INNER JOIN registrations r ON l.registration_id = r.id
    INNER JOIN students s ON r.student_id = s.id
    INNER JOIN users su ON s.user_id = su.id
    INNER JOIN instructors i ON l.instructor_id = i.id
    INNER JOIN users iu ON i.user_id = iu.id
    INNER JOIN cars c ON l.car_id = c.id;
END;