<?php namespace Corvo\Routes\Commands;

use Corvo\Routes\Components\CreateSection;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class CreateSectionCommand extends Command {

    /**
     * Command
     *
     * @var string
     */
    protected $name = 'corvo:section';
 
    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Create new section';
 
    /**
     * Execute
     *
     * @return void
     */
    public function fire()
    {
        try
        {
            $create = new CreateSection;

            $sectionName = $this->argument('section_name');
            
            $create->createSection($sectionName);

            $this->line('Created section: '.$sectionName);
        }
        catch(Exception $ex)
        {
            $this->line('Error! '.$ex->getMessage());
            return;
        }
    }

    /**
     * Arguments
     * 
     * @return array array with arguments
     */
    protected function getArguments()
    {
        return array(
            // section_name is required, is the name of the section
            array('section_name', InputArgument::REQUIRED, 'Name of the section'),
        );
    }
}
