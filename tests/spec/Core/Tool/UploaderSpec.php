<?php

namespace spec\Ushahidi\Core\Tools;

use League\Flysystem\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ushahidi\Core\Tools\FileData;
use Ushahidi\Core\Tools\UploadData;
use Ushahidi\App\Multisite\MultisiteManager;
use Ushahidi\App\Multisite\Site;

class UploaderSpec extends ObjectBehavior
{
    public function let(Filesystem $fs, MultisiteManager $multisite)
    {
        $this->beConstructedWith($fs, $multisite);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Ushahidi\Core\Tools\Uploader');
    }

    public function it_does_convert_uploads_to_files(UploadData $input, Site $site, $fs, $multisite)
    {
        // define the filename to avoid the unique prefix being added, making the
        // filepath consistently testable
        $filename = 'test-file.png';
        $filepath = 'deployment.domain.com/t/e/'.$filename;

        // Create a temporary file, for a fake upload.
        $tmpfile = tempnam(sys_get_temp_dir(), 'spec');

        // The filesystem will consume a stream, but mocking it is pointless for the spec.
        $stream = Argument::any();

        // Define the upload...
        $input->name = 'upload.png';
        $input->tmp_name = $tmpfile;
        $input->type = 'image/png';
        $input->size = 1024;
        $input->error = UPLOAD_ERR_OK;

        // ... which will be written from the stream
        $fs->putStream($filepath, $stream, ['mimetype' => 'image/png'])->shouldBeCalled();

        // ... and maintain the same size and mime type
        $fs->getSize($filepath)->willReturn(1024);
        $fs->getMimetype($filepath)->willReturn('image/png');

        $multisite->getSite()->shouldBeCalled()->willReturn($site);

        $site->getCdnPrefix()->shouldBeCalled()->willReturn('deployment.domain.com');

        // ... resulting a file.
        $this->upload($input, $filename)->shouldReturnAnInstanceOf('Ushahidi\Core\Tools\FileData');
    }
}
