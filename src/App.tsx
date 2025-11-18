import React, { useState, useEffect } from 'react';
import Header from './components/Header';
import ArticleCard from './components/ArticleCard';
import AIToolCard from './components/AIToolCard';
import PortfolioCard from './components/PortfolioCard';
import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';

interface Article {
  id: number;
  title: string;
  summary: string;
  date: string;
  category: string;
}

interface AITool {
  id: number;
  name: string;
  description: string;
}

interface PortfolioItem {
  id: number;
  name: string;
  technologies: string;
  link: string;
}

function App() {
  const [articles, setArticles] = useState<Article[]>([]);
  const [aiTools, setAiTools] = useState<AITool[]>([]);
  const [portfolio, setPortfolio] = useState<PortfolioItem[]>([]);

  useEffect(() => {
    // Fetch data from API endpoints
    const fetchData = async () => {
      try {
        const [articlesRes, toolsRes, portfolioRes] = await Promise.all([
          fetch('/api/articles'),
          fetch('/api/ai-tools'),
          fetch('/api/portfolio')
        ]);

        const articlesData = await articlesRes.json();
        const toolsData = await toolsRes.json();
        const portfolioData = await portfolioRes.json();

        setArticles(articlesData);
        setAiTools(toolsData);
        setPortfolio(portfolioData);
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    };

    fetchData();
  }, []);

  return (
    <div className="App">
      <Header />
      <main>
        {/* Hero Section */}
        <section className="bg-primary text-white py-5">
          <div className="container">
            <div className="row">
              <div className="col-lg-8 mx-auto text-center">
                <h1 className="display-4 fw-bold">TechGlow</h1>
                <p className="lead">Showcasing Innovation in Technology and AI</p>
              </div>
            </div>
          </div>
        </section>

        {/* Articles Section */}
        <section className="py-5" id="articles">
          <div className="container">
            <h2 className="text-center mb-4">Artikel Blog</h2>
            <div className="row">
              {articles.slice(0, 6).map((article) => (
                <div key={article.id} className="col-md-6 col-lg-4 mb-4">
                  <ArticleCard
                    title={article.title}
                    summary={article.summary}
                    date={article.date}
                    category={article.category}
                  />
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* AI Tools Section */}
        <section className="py-5 bg-light" id="tools">
          <div className="container">
            <h2 className="text-center mb-4">AI Tools</h2>
            <div className="row">
              {aiTools.slice(0, 6).map((tool) => (
                <div key={tool.id} className="col-md-6 col-lg-4 mb-4">
                  <AIToolCard
                    name={tool.name}
                    description={tool.description}
                  />
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* Portfolio Section */}
        <section className="py-5" id="portfolio">
          <div className="container">
            <h2 className="text-center mb-4">Portofolio</h2>
            <div className="row">
              {portfolio.slice(0, 3).map((item) => (
                <div key={item.id} className="col-md-6 col-lg-4 mb-4">
                  <PortfolioCard
                    name={item.name}
                    technologies={item.technologies}
                    link={item.link}
                  />
                </div>
              ))}
            </div>
          </div>
        </section>
      </main>

      {/* Footer */}
      <footer className="bg-dark text-white py-4">
        <div className="container text-center">
          <p>&copy; 2024 TechGlow. All rights reserved.</p>
        </div>
      </footer>
    </div>
  );
}

export default App;