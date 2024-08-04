<?php

namespace App\Command;

use App\Entity\ContactForm;
use App\Entity\ContactFormUrlPost;
use App\Entity\Enum\LanguageEnum;
use App\Entity\GeneralData;
use App\Entity\GlobalTags;
use App\Entity\PageSeo;
use App\Repository\ContactFormRepository;
use App\Repository\ContactFormUrlPostRepository;
use App\Repository\GeneralDataRepository;
use App\Repository\GlobalTagsRepository;
use App\Repository\PageSeoRepository;
use Doctrine\Inflector\Language;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-sample-data',
    description: 'Criar dados iniciais para o sistema',
)]
class CreateSampleDataCommand extends Command
{
    public function __construct(
        private GeneralDataRepository $generalDataRepository,
        private PageSeoRepository $pageSeoRepository,
        private GlobalTagsRepository $globalTagsRepository,
        private ContactFormUrlPostRepository $contactFormUrlPostRepository,
        private EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        foreach (LanguageEnum::getOptions() as $index => $option) {
            $pageSeo = $this->pageSeoRepository->findOneBy(['language' => $option]);
            if ($pageSeo) {
                $io->writeln('Page Seo em '.$index.'<comment> já existe!</comment>');
            } else {
                $io->writeln('Page Seo em '.$index.'<comment> criada!</comment>');
                $pageSeo = new PageSeo();
                # homePageTitle
                $pageSeo->setHomePageTitle('Título da Home');
                $pageSeo->setHomePageDescription('Descrição da Home');
                ##aboutUsPageTitle
                $pageSeo->setAboutUsPageTitle('Título da Sobre Nós');
                $pageSeo->setAboutUsPageDescription('Descrição da Sobre Nós');
                ##productListingPageTitle
                $pageSeo->setProductListingPageTitle('Título da Lista de Notícias');
                $pageSeo->setProductListingPageDescription('Descrição da Lista de Notícias');
                ##newsListingPageTitle
                $pageSeo->setNewsListingPageTitle('Título da Lista de Notícias');
                $pageSeo->setNewsListingPageDescription('Descrição da Lista de Notícias');
                # serviceListingPageTitle
                $pageSeo->setServiceListingPageTitle('Título da Lista de Serviços');
                $pageSeo->setServiceListingPageDescription('Descrição da Lista de Serviços');
                # financingListPageTitle
                $pageSeo->setFinancingListPageTitle('Título da Lista de Financiamentos');
                $pageSeo->setFinancingListPageDescription('Descrição da Lista de Financiamentos');
                # videoListingPageTitle
                $pageSeo->setVideoListingPageTitle('Título da Lista de Vídeos');
                $pageSeo->setVideoListingPageDescription('Descrição da Lista de Vídeos');
                $pageSeo->setLanguage($option);

                $this->em->persist($pageSeo);
                $this->em->flush($pageSeo);
            }
        }

        $generalData = $this->generalDataRepository->find(1);
        if ($generalData) {
            $io->writeln('General Data <comment> já existe!</comment>');
        } else {
            $io->writeln('General Data <comment> criada!</comment>');
            $generalData = new GeneralData();
            $generalData->setEmail('email@dominio.com');
            $generalData->setAddress('Rua X, 123');
            $generalData->setPhone('(11) 3333-2222');

            $this->em->persist($generalData);
            $this->em->flush($generalData);
        }

        $globalTags = $this->globalTagsRepository->findAll();
        if ($globalTags) {
            $io->writeln('Global Tags <comment> já existe!</comment>');
        } else {
            $io->writeln('Global Tags <comment> criada!</comment>');
            $globalTags = new GlobalTags();
            $globalTags->setGa4('Ga4');
            $globalTags->setTagsGoogleAds('Google ads');
            $globalTags->setPixelMetaAds('Meta pixel');

            $this->em->persist($globalTags);
            $this->em->flush($globalTags);
        }

        $contactForm = $this->contactFormUrlPostRepository->findAll();
        if ($contactForm) {
            $io->writeln('Formulário URL <comment> já existe!</comment>');
        } else {
            $io->writeln('Formulário Tags <comment> criada!</comment>');
            $contactForm = new ContactFormUrlPost();
            $contactForm->setUrl('https://www.google.com');

            $this->em->persist($contactForm);
            $this->em->flush($contactForm);
        }

        $io->success('Dados injetados com sucesso!');

        return Command::SUCCESS;
    }
}
