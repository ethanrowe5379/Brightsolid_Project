INSERT INTO platform
VALUES
	(2, 'AWS'),
    (3, 'Azure')
;

INSERT INTO customer
VALUES
	(1, 'brightsolid')
;

INSERT INTO user_role
VALUES
	(1, 'system'),
	(2, 'auditor'),
	(3, 'manager'),
	(4, 'admin')
;

INSERT INTO resource_type
VALUES
	(1, 'ec2', 2),
    (2, 'ebs', 2),
    (3, 'asg', 2),
    (4, 'efs', 2),
    (5, 'app-elb', 2),
    (6, 'eni', 2),
    (7, 'lambda', 2),
    (10, 'rds', 2),
    (11, 'elb', 2),
    (12, 's3', 2)
;

INSERT INTO account
VALUES
	(1, '011072135518', 2, 1)
;

INSERT INTO user
VALUES
	(1, 'system', 1, 1,'7833dc6e82e9378117bcb03128ac8fdd95d9073161ebc963783b3010dd847ff3'),
	(2, 'user1', 1, 2,'7833dc6e82e9378117bcb03128ac8fdd95d9073161ebc963783b3010dd847ff3'),
	(3, 'user2', 1, 3,'7833dc6e82e9378117bcb03128ac8fdd95d9073161ebc963783b3010dd847ff3'),
	(4, 'admin', 1, 4,'8d71292c2d52e804d6e43412655bf3ec8020354446913b30e0813baaf675651e')
;

INSERT INTO resource
VALUES
	(1128, 'i-060476bb31df657e7', 1, 1, 'vault test', '2022-09-08 14:18:25.529 +0100', '"{""AmiLaunchIndex"": 0, ""ImageId"": ""ami-0089b31e09ac3fffc"", ""InstanceId"": ""i-060476bb31df657e7"", ""InstanceType"": ""t2.micro"", ""KeyName"": ""pc-dev-keypair01"", ""LaunchTime"": ""2021-04-12T15:41:40+00:00"", ""Monitoring"": {""State"": ""disabled""}, ""Placement"": {""AvailabilityZone"": ""eu-west-2a"", ""GroupName"": """", ""Tenancy"": ""default""}, ""PrivateDnsName"": ""ip-10-184-0-18.eu-west-2.compute.internal"", ""PrivateIpAddress"": ""10.184.0.18"", ""ProductCodes"": [], ""PublicDnsName"": """", ""State"": {""Code"": 80, ""Name"": ""stopped""}, ""StateTransitionReason"": ""User initiated (2021-04-12 15:43:14 GMT)"", ""SubnetId"": ""subnet-0385927a7d61e8706"", ""VpcId"": ""vpc-05da5d22d7bd6f8cf"", ""Architecture"": ""x86_64"", ""BlockDeviceMappings"": [{""DeviceName"": ""/dev/xvda"", ""Ebs"": {""AttachTime"": ""2020-02-10T21:21:24+00:00"", ""DeleteOnTermination"": true, ""Status"": ""attached"", ""VolumeId"": ""vol-0e181efd2ccb65947""}}], ""ClientToken"": """", ""EbsOptimized"": false, ""EnaSupport"": true, ""Hypervisor"": ""xen"", ""IamInstanceProfile"": {""Arn"": ""arn:aws:iam::011072135518:instance-profile/vaultInstanceProfile"", ""Id"": ""AIPAQFE7TMFPMA6DXMOQM""}, ""NetworkInterfaces"": [{""Attachment"": {""AttachTime"": ""2020-02-10T21:21:23+00:00"", ""AttachmentId"": ""eni-attach-0ab8f83f7f6acfb0a"", ""DeleteOnTermination"": true, ""DeviceIndex"": 0, ""Status"": ""attached"", ""NetworkCardIndex"": 0}, ""Description"": """", ""Groups"": [{""GroupName"": ""launch-wizard-4"", ""GroupId"": ""sg-0072d99591e9b5afb""}], ""Ipv6Addresses"": [], ""MacAddress"": ""06:70:52:26:68:62"", ""NetworkInterfaceId"": ""eni-0aa1501647f12ae7f"", ""OwnerId"": ""011072135518"", ""PrivateDnsName"": ""ip-10-184-0-18.eu-west-2.compute.internal"", ""PrivateIpAddress"": ""10.184.0.18"", ""PrivateIpAddresses"": [{""Primary"": true, ""PrivateDnsName"": ""ip-10-184-0-18.eu-west-2.compute.internal"", ""PrivateIpAddress"": ""10.184.0.18""}], ""SourceDestCheck"": true, ""Status"": ""in-use"", ""SubnetId"": ""subnet-0385927a7d61e8706"", ""VpcId"": ""vpc-05da5d22d7bd6f8cf"", ""InterfaceType"": ""interface""}], ""RootDeviceName"": ""/dev/xvda"", ""RootDeviceType"": ""ebs"", ""SecurityGroups"": [{""GroupName"": ""launch-wizard-4"", ""GroupId"": ""sg-0072d99591e9b5afb""}], ""SourceDestCheck"": true, ""StateReason"": {""Code"": ""Client.UserInitiatedShutdown"", ""Message"": ""Client.UserInitiatedShutdown: User initiated shutdown""}, ""Tags"": [{""Key"": ""customer"", ""Value"": ""brightsolid""}, {""Key"": ""customer_code"", ""Value"": ""16BSOT01""}, {""Key"": ""project_code"", ""Value"": ""08-BSOT-931""}, {""Key"": ""Name"", ""Value"": ""vault test""}, {""Key"": ""resource_owner"", ""Value"": ""109bb604.brightsolid.com@emea.teams.ms""}, {""Key"": ""c7n:FindingId:ec2-instance-with-invalid-customer"", ""Value"": ""eu-west-2/011072135518/10b41698007565e1d396787f129479ce/f2e74d392bf3eaf1359eb8e6c4530568:2020-09-10T16:10:14.602386+00:00""}], ""VirtualizationType"": ""hvm"", ""CpuOptions"": {""CoreCount"": 1, ""ThreadsPerCore"": 1}, ""CapacityReservationSpecification"": {""CapacityReservationPreference"": ""open""}, ""HibernationOptions"": {""Configured"": false}, ""MetadataOptions"": {""State"": ""applied"", ""HttpTokens"": ""optional"", ""HttpPutResponseHopLimit"": 1, ""HttpEndpoint"": ""enabled"", ""HttpProtocolIpv6"": ""disabled"", ""InstanceMetadataTags"": ""disabled""}, ""EnclaveOptions"": {""Enabled"": false}, ""PlatformDetails"": ""Linux/UNIX"", ""UsageOperation"": ""RunInstances"", ""UsageOperationUpdateTime"": ""2020-02-10T21:21:23+00:00"", ""PrivateDnsNameOptions"": {}, ""MaintenanceOptions"": {""AutoRecovery"": ""default""}}"')
;

INSERT INTO rule
VALUES
	(1, 'ebs-detect-unencrypted-volume', 2, 'If a developer creates an AWS EC2 Instance and the AWS EBS storage volume(s) attached to the instance are not encrypted then the the developer and compliance team are notified.'),
    (2, 's3-detect-unauthorised-public-bucket', 12, 'If a developer creates or updates AWS S3 Bucket to make it publically visible to anyone on the internet, then automatically change the S3 Bucket configuration to make it private and the developer and compliance team are notified.'),
    (3, 'ec2-detect-unauthorised-public-instance', 1, 'If a developer creates an AWS EC2 Instance and attaches the instance to a public subnet (e.g. a subnet which is addressable to/from the internet) then the AWS EC2 instance is automatically terminated and the developer and compliance team are notified'),
    (4, 's3-detect-unencrypted-bucket', 12, 'If a developer creates or updates AWS S3 Bucket and sets the default encryption to unencrypted, then automatically change the S3 Bucket configuration to make the encryption default use the default S3 encryption key, and the developer and compliance team are notified.'),
    (5, 'efs-detect-unencrypted-filesystem', 4, 'If a developer creates or updates an EFS Volume and sets the encryption setting to unencrypted, the developer and compliance team are notified.'),
    (6, 'rds-detect-unauthorised-public-db-instance', 10, 'If a developer creates an AWS RDS Instance and attaches the instance to a public subnet (e.g. a subnet which is addressable to/from the internet) then the developer and compliance team are notified'),
    (7, 'rds-detect-unencrypted-instances', 10, 'If a developer creates an AWS RDS Instance and the storage attached to the Instance is not encrypted then the the developer and compliance team are notified.'),
    (8, 'lambda-detect-unauthorised-public-function', 7, 'If a developer creates an AWS Lambda function and attaches the instance to a public subnet (e.g. a subnet which is addressable to/from the internet) then the developer and compliance team are notified')
;

/*INSERT INTO non_compliance_audit
VALUES
	(NULL, 1, 1, 1, 'action1', '14/07/22')
;*/

INSERT INTO exception
VALUES
	(1, 1, 4, 1, 'bs-quorum-dropbox', 'Enabled by system', '2022-12-12 16:23:59.759 +0000', '2022-09-12 17:25:36.091 +0100'),
    (3, 1, 4, 1, 'bsol-dev-bakery-assets', 'Enabled by system', '2022-12-12 16:23:59.759 +0000', '2022-09-12 17:25:36.091 +0100')
;
    
/*INSERT INTO exception_audit
VALUES
	(NULL, 1, 1, 1, 1, 'action', '2022-12-12 00:00:00.000 +0000', 'old_exception_value', 'new_exception_value', 'old_justification', 'new_justification', '2022-12-12 00:00:00.000 +0000', '2022-12-12 00:00:00.000 +0000')
;*/

INSERT INTO non_compliance
VALUES
	(1269, 1),
	(1151, 1),
	(1152, 1),
	(1153, 1),
	(1323, 2),
	(1139, 2),
	(1140, 2),
	(1325, 2),
	(1328, 2),
	(1141, 2),
	(1142, 2),
	(1143, 2),
	(1144, 3),
	(1319, 4),
	(1320, 4),
	(1321, 4),
	(1325, 4),
	(1324, 4),
	(1145, 4),
	(1329, 4),
	(1330, 4),
	(1335, 4),
	(1138, 4)
;
    
    
