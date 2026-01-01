-- Create contacts table
CREATE TABLE IF NOT EXISTS contacts (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(50),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some sample data
INSERT INTO contacts (name, email, phone, notes) VALUES
    ('Max Mustermann', 'max@example.com', '+49 123 456789', 'Erster Testkontakt'),
    ('Erika Musterfrau', 'erika@example.com', '+49 987 654321', 'Zweiter Testkontakt'),
    ('Hans Schmidt', 'hans.schmidt@example.com', '+49 555 123456', 'Geschäftskontakt');
