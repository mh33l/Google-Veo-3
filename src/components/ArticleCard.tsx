import React from 'react';

interface ArticleCardProps {
  title: string;
  summary: string;
  date: string;
  category: string;
}

const ArticleCard: React.FC<ArticleCardProps> = ({ title, summary, date, category }) => {
  return (
    <div className="card h-100">
      <div className="card-body">
        <div className="d-flex align-items-center mb-2">
          <i className="fas fa-newspaper text-primary me-2"></i>
          <small className="text-muted">{category}</small>
        </div>
        <h5 className="card-title">{title}</h5>
        <p className="card-text">{summary}</p>
        <small className="text-muted">{new Date(date).toLocaleDateString()}</small>
      </div>
    </div>
  );
};

export default ArticleCard;