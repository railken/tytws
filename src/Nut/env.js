export const env = {
	api: {
		url: 'https://tytws.railken.dev.zero.buongustai.ovh',
	},
	oauth: {
		github: {
			client: {
				id: "ac3be8271ac7f65a407b",
				secret: "db3d93ff94b6f928879fca5ad179ffabc7ce7a0c"
			}
		},
		gitlab: {
			client: {
				id: "2c7bfe9892ea09fe7f255f4a692a552a7f6b9e8c817b77a65c693df4b87f40b8",
				secret: "a0d3eee3a7508ce12e354cda56a81d8f0bb3dded6dde36af95f521e7636b2ca4"
			},
			redirect_uri: "https://tytws.railken.dev.zero.buongustai.ovh/oauth/gitlab/token"
		}
	}
};
