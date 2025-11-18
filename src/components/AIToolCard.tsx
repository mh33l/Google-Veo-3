import React from 'react';

interface AIToolCardProps {
  name: string;
  description: string;
}

const AIToolCard: React.FC<AIToolCardProps> = ({ name, description }) => {
  return (
    <div className="card h-100">
      <div className="card-body">
        <div className="d-flex align-items-center mb-2">
          <i className="fas fa-robot text-success me-2"></i>
          <h6 className="card-title mb-0">{name}</h6>
        </div>
        <p className="card-text">{description}</p>
      </div>
    </div>
  );
};

export default AIToolCard;