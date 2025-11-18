-- Create articles table
CREATE TABLE IF NOT EXISTS articles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  summary TEXT,
  date DATE NOT NULL,
  category VARCHAR(100)
);

-- Create ai_tools table
CREATE TABLE IF NOT EXISTS ai_tools (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT
);

-- Create portfolio table
CREATE TABLE IF NOT EXISTS portfolio (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  technologies VARCHAR(255),
  link VARCHAR(255)
);

-- Insert sample data for articles
INSERT INTO articles (title, summary, date, category) VALUES
('Getting Started with React', 'Learn the basics of React development and build your first component.', '2024-01-15', 'Tutorial'),
('AI in Web Development', 'Exploring how artificial intelligence is transforming web development practices.', '2024-01-10', 'Technology'),
('Database Optimization Tips', 'Best practices for optimizing database performance in web applications.', '2024-01-05', 'Database'),
('Modern CSS Techniques', 'Advanced CSS techniques for creating responsive and beautiful web designs.', '2023-12-28', 'Design'),
('Node.js Best Practices', 'Essential best practices for building scalable Node.js applications.', '2023-12-20', 'Backend'),
('TypeScript Migration Guide', 'Step-by-step guide to migrating JavaScript projects to TypeScript.', '2023-12-15', 'Programming');

-- Insert sample data for AI tools
INSERT INTO ai_tools (name, description) VALUES
('Blackbox.ai', 'Advanced AI coding assistant for developers'),
('ChatGPT', 'Conversational AI for various tasks and queries'),
('GitHub Copilot', 'AI-powered code completion and suggestions'),
('Gemini', 'Google\'s multimodal AI assistant'),
('Claude', 'Anthropic\'s helpful and honest AI assistant'),
('Bard', 'Google\'s conversational AI chatbot');

-- Insert sample data for portfolio
INSERT INTO portfolio (name, technologies, link) VALUES
('E-commerce Platform', 'React, Node.js, MongoDB', 'https://example.com/ecommerce'),
('Task Management App', 'Vue.js, Express, PostgreSQL', 'https://example.com/tasks'),
('Weather Dashboard', 'React, TypeScript, OpenWeather API', 'https://example.com/weather');