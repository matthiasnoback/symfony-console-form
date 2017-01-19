<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\FormInteractor;
use Matthias\SymfonyConsoleForm\Bridge\Interaction\FormJsonTemplateInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormFactoryInterface;

class JsonFormTemplateCommand extends Command
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FormJsonTemplateInterface
     */
    private $formInteractor;

    /**
     * @param FormFactoryInterface $formFactory
     * @param FormInteractor       $formInteractor
     * @param null                 $name
     */
    public function __construct(FormFactoryInterface $formFactory, FormInteractor $formInteractor, $name = null)
    {
        $this->formFactory = $formFactory;
        $this->formInteractor = $formInteractor;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('matthias:form:json_template')
            ->setDescription('Displays a json template from a FormType')
            ->addArgument('forms', InputArgument::IS_ARRAY, 'formType name space')
            ->addOption('inline', null, InputOption::VALUE_OPTIONAL, 'remove pretty price', false)
            ->addOption('output-file', null, InputOption::VALUE_OPTIONAL, 'Output file with json result', null)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formClasses = $input->getArgument('forms');
        $inlineResultFormat = $input->getOption('inline');
        $outputFile = $input->getOption('output-file');

        if (count($formClasses) == 0) {
            throw new \RuntimeException("The input 'forms' are required");
        }

        $formAttributesArr = [];

        foreach ($formClasses as $formClass) {
            if (!class_exists($formClass)) {
                throw new \RuntimeException("Form class '$formClass' doesn't exist");
            }

            $form = $this->formFactory->create($formClass);
            $formAttributesArr[$form->getName()] = $this->formInteractor->getAttributesWithFakeData($form);
        }

        $io = new SymfonyStyle($input, $output);

        if (!$inlineResultFormat) {
            $successMsg = 'JSON was generated!';
            $io->success($successMsg);
        }

        $jsonFormatted = json_encode($formAttributesArr, $inlineResultFormat ? 0 : JSON_PRETTY_PRINT);

        if ($outputFile) {
            $fsystem = new Filesystem();
            $fsystem->dumpFile($outputFile, $jsonFormatted);

            if (!$inlineResultFormat) {
                $output->writeln(sprintf("<info>[file+]</info> %s\n", $outputFile));
            }
        }

        $output->writeln($jsonFormatted);
    }
}
