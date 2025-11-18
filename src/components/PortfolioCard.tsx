import React from 'react';

interface PortfolioCardProps {
  name: string;
  technologies: string;
  link: string;
}

const PortfolioCard: React.FC<PortfolioCardProps> = ({ name, technologies, link }) => {
  return (
    <div className="card h-100">
      <div className="card-body">
        <div className="d-flex align-items-center mb-2">
          <i className="fas fa-project-diagram text-info me-2"></i>
          <h6 className="card-title mb-0">{name}</h6>
        </div>
        <p className="card-text">
          <strong>Technologies:</strong> {technologies}
        </p>
        <a href={link} className="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer">
          View Project
        </a>
      </div>
    </div>
  );
};

export default PortfolioCard;