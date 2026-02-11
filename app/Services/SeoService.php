<?php

namespace App\Services;

/**
 * SEO Meta Tags Service
 * Centraliza a geração de meta tags para todas as páginas
 */
class SeoService
{
    protected string $title = 'Paróquia São Paulo Apóstolo';
    protected string $description = 'Paróquia católica em Umuarama dedicada aos ensinamentos de Jesus Cristo.';
    protected ?string $image = null;
    protected string $url;
    protected string $type = 'website';
    protected ?string $canonical = null;

    public function __construct()
    {
        $this->url = request()->url();
    }

    public function setTitle(string $title): self
    {
        $this->title = $title . ' - Paróquia São Paulo Apóstolo';
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = substr($description, 0, 160);
        return $this;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image ? asset(str_replace('public/', '', $image)) : null;
        return $this;
    }

    public function setCanonical(string $canonical): self
    {
        $this->canonical = $canonical;
        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function render(): string
    {
        $html = '';

        // Basic meta tags
        $html .= '<meta name="description" content="' . htmlspecialchars($this->description, ENT_QUOTES) . '">' . "\n";
        $html .= '<meta name="theme-color" content="#8B1E3F">' . "\n";

        // OpenGraph tags
        $html .= '<meta property="og:title" content="' . htmlspecialchars($this->title, ENT_QUOTES) . '">' . "\n";
        $html .= '<meta property="og:description" content="' . htmlspecialchars($this->description, ENT_QUOTES) . '">' . "\n";
        $html .= '<meta property="og:url" content="' . htmlspecialchars($this->url, ENT_QUOTES) . '">' . "\n";
        $html .= '<meta property="og:type" content="' . $this->type . '">' . "\n";

        if ($this->image) {
            $html .= '<meta property="og:image" content="' . htmlspecialchars($this->image, ENT_QUOTES) . '">' . "\n";
            $html .= '<meta property="og:image:type" content="image/jpeg">' . "\n";
        } else {
            $html .= '<meta property="og:image" content="' . asset('images/sao-paulo-logo.png') . '">' . "\n";
        }

        // Twitter Card tags
        $html .= '<meta name="twitter:card" content="summary_large_image">' . "\n";
        $html .= '<meta name="twitter:title" content="' . htmlspecialchars($this->title, ENT_QUOTES) . '">' . "\n";
        $html .= '<meta name="twitter:description" content="' . htmlspecialchars($this->description, ENT_QUOTES) . '">' . "\n";

        if ($this->image) {
            $html .= '<meta name="twitter:image" content="' . htmlspecialchars($this->image, ENT_QUOTES) . '">' . "\n";
        }

        // Canonical link
        if ($this->canonical) {
            $html .= '<link rel="canonical" href="' . htmlspecialchars($this->canonical, ENT_QUOTES) . '">' . "\n";
        } else {
            $html .= '<link rel="canonical" href="' . htmlspecialchars($this->url, ENT_QUOTES) . '">' . "\n";
        }

        return $html;
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
